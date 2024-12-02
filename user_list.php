<?php
session_start();
include("funcs.php");
sschk();
admin_chk();

//DB接続
$pdo = db_conn();

//ユーザー一覧を取得
$sql = "SELECT * FROM users WHERE life_flg=1";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//データ表示
$view = "";
if ($status == false) {
    sql_error($stmt);
} else {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= generate_user_row($row);
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー一覧</title>
    <?= get_common_style() ?>
    <style>
        table {
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php include("includes/header.php"); ?>
    <div class="container">
        <div class="header-section">
            <h1>ユーザー一覧</h1>
            <a href="user_add.php" class="btn">新規ユーザー登録</a>
        </div>
        <table>
            <tr>
                <th>名前</th>
                <th>ログインID</th>
                <th>権限</th>
                <th>操作</th>
            </tr>
            <?= $view ?>
        </table>
        <a href="main.php" class="back-link">戻る</a>
    </div>
</body>

</html>