<?php
session_start();

$lid = $_POST["lid"];
$lpw = $_POST["lpw"];

include "funcs.php";
$pdo = db_conn();

//SQLを作成
$stmt = $pdo->prepare("SELECT * FROM users WHERE lid = :lid");
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$status = $stmt->execute();

//デバッグ用
//var_dump($status);

//SQLエラー
if ($status == false) {
    sql_error($stmt);
}

//抽出データ数を取得
$val = $stmt->fetch();

//該当レコードがあればSESSIONに値を代入
if ($val["id"] != "") {
    //Login成功時
    $_SESSION["chk_ssid"] = session_id();
    $_SESSION["kanrisya_flg"] = $val['kanrisya_flg'];
    $_SESSION["name"] = $val['name'];
    $_SESSION["id"] = $val['id'];

    //デバッグ用
    //var_dump($_SESSION);

    redirect("main.php");
} else {
    //Login失敗時
    redirect("index.php");
}

exit();
