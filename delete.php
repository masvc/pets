<?php
session_start();
include("funcs.php");
sschk();

// 管理者チェック
if ($_SESSION["kanrisya_flg"] != 1) {
    exit("権限がありません");
}

// POSTデータ取得
$id = $_POST["id"];

// データベース接続
$pdo = db_conn();

// DELETE文を作成
$stmt = $pdo->prepare("DELETE FROM animals WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// 削除結果を返す
if ($status) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "削除に失敗しました"]);
}
