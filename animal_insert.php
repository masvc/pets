<?php
session_start();
include("funcs.php");
sschk();

// 管理者チェック
if ($_SESSION["kanrisya_flg"] != 1) {
    exit("権限がありません");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // POSTデータ取得
    $name = filter_input(INPUT_POST, "name");

    // File Upload
    $upload = $_FILES['imgfile'];
    $upload_name = basename($upload['name']);
    $upload_dir = "images/";
    $upload_path = $upload_dir . $upload_name;

    // ファイルの拡張子チェック
    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
    $file_ext = strtolower(pathinfo($upload_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_ext)) {
        exit('許可されていないファイル形式です');
    }

    // ファイルアップロード
    if (move_uploaded_file($upload['tmp_name'], $upload_path)) {
        // DB接続
        $pdo = db_conn();

        // SQL作成&実行
        $stmt = $pdo->prepare("INSERT INTO animals (name, imgfile, indate) VALUES (:name, :imgfile, sysdate())");
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':imgfile', $upload_name, PDO::PARAM_STR);
        $status = $stmt->execute();

        // データ登録処理後
        if ($status == false) {
            sql_error($stmt);
        } else {
            redirect("main.php");
        }
    } else {
        exit('ファイルのアップロードに失敗しました');
    }
}
