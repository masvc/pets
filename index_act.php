<?php
session_start();

$lid = $_POST["lid"];
$lpw = $_POST["lpw"];

include "funcs.php";
$pdo = db_conn();

$stmt = $pdo->prepare("SELECT * FROM users WHERE lid = :lid AND life_flg=0");
$stmt->bindValue(":lid", $lid, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
}

$val = $stmt->fetch();
$count = $stmt->fetchColumn();

$pw = password_verify($lpw, $val["lpw"]);
if ($pw) {
    $_SESSION["chk_ssid"] = session_id();
    $_SESSION["kanrisya_flg"] = $val["kanrisya_flg"];
    $_SESSION["name"] = $val["name"];

    redirect("main.php");
} else {
    redirect("index.php");
}
