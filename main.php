<?php
session_start();
include("funcs.php");
sschk();

$pdo = db_conn();
$stmt = $pdo->prepare("SELECT * FROM animals");
$status = $stmt->execute();

$view = "";
if ($status == false) {
    sql_error($stmt);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= generate_animal_card($result);
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ペット一覧</title>
    <?= get_common_style() ?>
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
        }

        .animal-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 4px;
        }

        .control {
            text-align: center;
            padding: 2rem;
            margin: 2rem auto;
            max-width: 1200px;
        }

        .control div {
            display: inline-block;
            margin: 0.5rem 1rem;
        }

        .control button {
            background-color: #4a90e2;
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
            font-size: 1rem;
        }

        .control button:hover {
            background-color: #357abd;
        }

        .admin-buttons {
            margin-top: 5px;
            padding: 5px;
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .admin-buttons button {
            background-color: #6c757d;
        }

        .admin-buttons button:hover {
            background-color: #5a6268;
        }
    </style>
</head>


<body>
    <?php include("includes/header.php"); ?>

    <section class="board">
        <?= $view ?>
    </section>

    <section class="control">
        <div>
            <button onclick="location.href='favorite.php'">お気に入りを確認する</button>
        </div>
        <?php if ($_SESSION["kanrisya_flg"] == 1) { ?>
            <div class="admin-buttons">
                <button onclick="location.href='animal_add.php'">新規追加をする</button>
            </div>
            <div class="admin-buttons">
                <button onclick="location.href='user_list.php'">ユーザー一覧を確認する</button>
            </div>
        <?php } ?>
    </section>

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
                        alert('お気に入りに追加しました');
                    } else {
                        alert('追加に失敗しました');
                    }
                });
        }

        function deleteAnimal(id) {
            if (confirm('本当に削除しますか？')) {
                fetch('delete.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            id: id
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