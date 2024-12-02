<?php
session_start();
include("funcs.php");
sschk();

// POSTデータの取得
$data = json_decode(file_get_contents('php://input'), true);
$animal_id = $data['animal_id'];

$pdo = db_conn();

try {
    $stmt = $pdo->prepare("INSERT INTO favorites (user_id, animal_id) VALUES (:user_id, :animal_id)");
    $stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
    $stmt->bindValue(':animal_id', $animal_id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
