<?php
session_start();
include("funcs.php");
sschk();

$data = json_decode(file_get_contents('php://input'), true);
$animal_id = $data['animal_id'];

try {
    $pdo = db_conn();

    db_transaction($pdo, function ($pdo) use ($animal_id) {
        $stmt = $pdo->prepare("INSERT INTO favorites (user_id, animal_id) VALUES (:user_id, :animal_id)");
        $stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->bindValue(':animal_id', $animal_id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception('お気に入りの追加に失敗しました');
        }
    });

    send_json_response(true);
} catch (PDOException $e) {
    send_json_response(false, $e->getMessage());
}
