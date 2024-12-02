<?php
session_start();
include("funcs.php");

// デバッグ用
// var_dump($_SESSION);
// echo "Current Session ID: " . session_id();

sschk(); // セッションチェック

// データベース接続
$pdo = db_conn();
$stmt = $pdo->prepare("SELECT * FROM animals");
$status = $stmt->execute();

// データ表示
$view = "";
if ($status == false) {
    sql_error($stmt);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<div class="animal-card">';
        $view .= '<img src="images/' . h($result['imgfile']) . '" alt="' . h($result['name']) . '">';
        $view .= '<h3>' . h($result['name']) . '</h3>';
        $view .= '<p>登録日: ' . h(substr($result['indate'], 0, 10)) . '</p>';
        $view .= '<button onclick="addToFavorites(' . h($result['id']) . ')" class="favorite-btn">お気に入りに追加</button>';
        if ($_SESSION["kanrisya_flg"] == 1) {
            $view .= '<button onclick="deleteAnimal(' . h($result['id']) . ')" class="delete-btn">削除</button>';
        }
        $view .= '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アニマル一覧</title>
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
            transition: transform 0.2s;
        }

        .animal-card:hover {
            transform: translateY(-5px);
        }

        .animal-card h3 {
            margin: 10px 0;
            color: #333;
        }

        .animal-card p {
            color: #666;
            margin-bottom: 15px;
        }

        .favorite-btn {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .favorite-btn:hover {
            background-color: #45a049;
        }

        .control {
            text-align: center;
            padding: 20px;
        }

        .control button {
            margin: 10px;
            padding: 10px 20px;
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .header {
            background: #333;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            font-size: 0.9em;
        }

        .delete-btn {
            background-color: #ff4444;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
            margin-left: 10px;
        }

        .delete-btn:hover {
            background-color: #cc0000;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="user-info">
            <?= h($_SESSION["name"]) ?>さん、こんにちは
        </div>
        <nav>
            <a href="logout.php" style="color: white; text-decoration: none;">ログアウト</a>
        </nav>
    </header>

    <main>
        <section class="board">
            <?= $view ?>
        </section>
        <section class="control">
            <div>
                <button onclick="location.href='favorite.php'">お気に入りを確認する</button>
            </div>
            <?php if ($_SESSION["kanrisya_flg"] == 1) { ?>
                <div>
                    <button onclick="location.href='animal_add.php'">新規追加をする</button>
                </div>
            <?php } ?>
        </section>
    </main>

    <script>
        function addToFavorites(id) {
            fetch('favorite_add.php', {
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
                        alert('お気に入りに追加しました！');
                    } else {
                        if (data.error && data.error.includes('Duplicate')) {
                            alert('既にお気に入りに追加されています');
                        } else {
                            alert('追加に失敗しました');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('エラーが発生しました');
                });
        }

        function deleteAnimal(id) {
            if (confirm('本当に削除してもよろしいですか？')) {
                fetch('delete.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'id=' + id
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('削除しました');
                            location.reload();
                        } else {
                            alert('削除に失敗しました');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('エラーが発生しました');
                    });
            }
        }
    </script>
</body>

</html>