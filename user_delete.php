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

//削除処理（実際には論理削除）
$sql = "UPDATE users SET life_flg=0 WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//処理後のリダイレクト
if ($status == false) {
    sql_error($stmt);
} else {
    redirect("user_list.php");
}
