<?php
session_start();
include("funcs.php");
sschk();
admin_chk();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo = db_conn();

        db_transaction($pdo, function ($pdo) {
            $name = filter_input(INPUT_POST, "name");
            $lid = filter_input(INPUT_POST, "lid");
            $lpw = filter_input(INPUT_POST, "lpw");
            $kanrisya_flg = isset($_POST["kanrisya_flg"]) ? 1 : 0;

            $hashed_pw = hash_password($lpw);

            $stmt = $pdo->prepare("INSERT INTO users(name,lid,lpw,kanrisya_flg,life_flg) VALUES(:name,:lid,:lpw,:kanrisya_flg,1)");
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
            $stmt->bindValue(':lpw', $hashed_pw, PDO::PARAM_STR);
            $stmt->bindValue(':kanrisya_flg', $kanrisya_flg, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                throw new Exception('ユーザー登録に失敗しました');
            }
        });

        redirect("user_list.php");
    } catch (Exception $e) {
        sql_error($stmt);
    }
}
