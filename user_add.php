<?php
session_start();
include("funcs.php");
sschk();
admin_chk();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
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
        input[type="email"],
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
    <form method="POST" action="user_add_process.php">
        <h1>新規ユーザー登録</h1>
        <div class="form-group">
            <label for="name">名前：</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label for="lid">ログインID：</label>
            <input type="email" name="lid" required>
        </div>
        <div class="form-group">
            <label for="lpw">パスワード：</label>
            <input type="password" name="lpw" required>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="kanrisya_flg" value="1">
                管理者権限
            </label>
        </div>
        <button type="submit">登録</button>
        <a href="user_list.php" class="back-link">戻る</a>
    </form>
</body>

</html>