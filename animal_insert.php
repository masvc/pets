<?php
session_start();
include("funcs.php");
sschk();
admin_chk();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // ファイルアップロード処理
        $upload_name = handle_file_upload($_FILES['imgfile']);

        // DB接続
        $pdo = db_conn();

        // トランザクション処理
        db_transaction($pdo, function ($pdo) use ($upload_name) {
            $name = filter_input(INPUT_POST, "name");

            $stmt = $pdo->prepare("INSERT INTO animals (name, imgfile, indate) VALUES (:name, :imgfile, sysdate())");
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':imgfile', $upload_name, PDO::PARAM_STR);

            if (!$stmt->execute()) {
                throw new Exception('登録に失敗しました');
            }
        });

        redirect("main.php");
    } catch (Exception $e) {
        send_json_response(false, $e->getMessage());
    }
}
