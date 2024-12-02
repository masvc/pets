<?php
session_start();
include("funcs.php");
sschk();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, "name");
    $lid = filter_input(INPUT_POST, "lid");
    $lpw = filter_input(INPUT_POST, "lpw");
    $kanrisya_flg = filter_input(INPUT_POST, "kanrisya_flg");
    $lpw = password_hash($lpw, PASSWORD_DEFAULT); //パスワードハッシュ化

    $pdo = db_conn();

    $sql = "INSERT INTO users(name,lid,lpw,kanrisya_flg,life_flg)VALUES(:name,:lid,:lpw,:kanrisya_flg,1)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
    $stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
    $stmt->bindValue(':kanrisya_flg', $kanrisya_flg, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status == false) {
        sql_error($stmt);
    } else {
        redirect("user_list.php");
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
</head>

<body>
    <form method="POST">
        <div>
            <label for="name">名前：</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label for="lid">ログインID：</label>
            <input type="email" name="lid" required>
        </div>
        <div>
            <label for="lpw">パスワード：</label>
            <input type="password" name="lpw" required>
        </div>
        <div>
            <label for="kanrisya_flg">管理者：</label>
            <input type="checkbox" name="kanrisya_flg" value="1">
        </div>
        <input type="submit" value="登録">
    </form>
</body>

</html>