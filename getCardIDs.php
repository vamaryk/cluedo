<?php
include 'db.php';

header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents('php://input'), true);
$cardNames = $data['cardNames'] ?? [];

if (count($cardNames) !== 3) {
    http_response_code(400);
    echo json_encode(['error' => 'Требуется три карты.']);
    exit;
}

try {
    $placeholders = implode(',', array_fill(0, count($cardNames), '?'));
    $stmt = $pdo->prepare("SELECT ID, CardName FROM Cards WHERE ID IN ($placeholders)");
    $stmt->execute($cardNames);
    $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['cards' => $cards]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Ошибка БД: ' . $e->getMessage()]);
}




