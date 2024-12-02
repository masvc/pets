<?php
session_start();
include("funcs.php");
sschk();
admin_chk();

try {
    $pdo = db_conn();

    db_transaction($pdo, function ($pdo) {
        $id = filter_input(INPUT_POST, "id");
        $name = filter_input(INPUT_POST, "name");
        $lid = filter_input(INPUT_POST, "lid");
        $lpw = filter_input(INPUT_POST, "lpw");
        $kanrisya_flg = isset($_POST["kanrisya_flg"]) ? 1 : 0;

        if ($lpw != "") {
            $hashed_pw = hash_password($lpw);
            $sql = "UPDATE users SET name=:name, lid=:lid, lpw=:lpw, kanrisya_flg=:kanrisya_flg WHERE id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':lpw', $hashed_pw, PDO::PARAM_STR);
        } else {
            $sql = "UPDATE users SET name=:name, lid=:lid, kanrisya_flg=:kanrisya_flg WHERE id=:id";
            $stmt = $pdo->prepare($sql);
        }

        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
        $stmt->bindValue(':kanrisya_flg', $kanrisya_flg, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception('更新に失敗しました');
        }
    });

    redirect("user_list.php");
} catch (Exception $e) {
    sql_error($stmt);
}
