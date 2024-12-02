<?php
session_start();
include("funcs.php");
sschk();
admin_chk();

//管理者チェック
if ($_SESSION["kanrisya_flg"] != 1) {
    exit("権限がありません");
}

$id = $_GET["id"];

//DB接続
$pdo = db_conn();

//データ取得
$sql = "SELECT * FROM users WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
} else {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー編集</title>
    <style>
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include("includes/header.php"); ?>
    <form method="POST" action="user_update.php">
        <h1>ユーザー編集</h1>
        <div class="form-group">
            <label for="name">名前：</label>
            <input type="text" name="name" value="<?= h($row["name"]) ?>" required>
        </div>
        <div class="form-group">
            <label for="lid">ログインID：</label>
            <input type="text" name="lid" value="<?= h($row["lid"]) ?>" required>
        </div>
        <div class="form-group">
            <label for="lpw">パスワード（変更する場合のみ）：</label>
            <input type="password" name="lpw">
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="kanrisya_flg" value="1" <?= $row["kanrisya_flg"] == 1 ? 'checked' : '' ?>>
                管理者権限
            </label>
        </div>
        <input type="hidden" name="id" value="<?= h($row["id"]) ?>">
        <button type="submit">更新</button>
        <a href="user_list.php" class="back-link">戻る</a>
    </form>
</body>

</html>