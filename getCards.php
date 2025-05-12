<?php
include 'db.php';

header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['type'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Не указан тип карт']);
    exit;
}

$type = $data['type'];

try {
    $stmt = $pdo->prepare("SELECT ID, CardName FROM Cards WHERE CardType = ?");
    $stmt->execute([$type]);
    $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['cards' => $cards]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Ошибка БД: ' . $e->getMessage()]);
}
?>
