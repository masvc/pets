<?php
session_start();
include("funcs.php");
sschk();

$pdo = db_conn();

// お気に入りリストの取得
$stmt = $pdo->prepare("
    SELECT a.* 
    FROM animals a 
    JOIN favorites f ON a.id = f.animal_id 
    WHERE f.user_id = :user_id
");
$stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
$status = $stmt->execute();

$view = "";
if ($status == false) {
    sql_error($stmt);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<div class="animal-card">';
        $view .= '<img src="images/' . h($result['imgfile']) . '" alt="' . h($result['name']) . '">';
        $view .= '<h3>' . h($result['name']) . '</h3>';
        $view .= '<p>登録日: ' . h(substr($result['indate'], 0, 10)) . '</p>';
        $view .= '<button onclick="removeFromFavorites(' . h($result['id']) . ')" class="remove-btn">お気に入りから削除</button>';
        $view .= '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お気に入り一覧</title>
    <style>
        .board {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .animal-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .animal-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 4px;
        }

        .remove-btn {
            background-color: #dc3545;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .remove-btn:hover {
            background-color: #c82333;
        }

        .header {
            background: #333;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .back-btn {
            background-color: #6c757d;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <header class="header">
        <div>
            <h1>お気に入り一覧</h1>
        </div>
        <nav>
            <a href="main.php" class="back-btn">戻る</a>
            <a href="logout.php" style="color: white; text-decoration: none; margin-left: 10px;">ログアウト</a>
        </nav>
    </header>

    <main>
        <section class="board">
            <?= $view ?>
        </section>
    </main>

    <script>
        function removeFromFavorites(id) {
            if (confirm('お気に入りから削除しますか？')) {
                fetch('favorite_remove.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            animal_id: id
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('削除に失敗しました');
                        }
                    });
            }
        }
    </script>
</body>

</html>