<?php
include 'db.php';

header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents('php://input'), true);
$cardIDs = $data['cardIDs'] ?? [];

if (count($cardIDs) !== 3) {
    http_response_code(400);
    echo json_encode(['error' => 'Требуется три ID карт.']);
    exit;
}

try {
    $placeholders = implode(',', array_fill(0, count($cardIDs), '?'));
    
    $stmt = $pdo->prepare("
        SELECT gc.CardPlayer, c.CardName 
        FROM GameCards gc
        JOIN Cards c ON gc.CardName = c.ID
        WHERE gc.CardName IN ($placeholders)
        ORDER BY gc.CardPlayer ASC
        LIMIT 1
    ");
    
    $stmt->execute($cardIDs);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode([
            'playerID' => $result['CardPlayer'], 
            'cardName' => $result['CardName'], 
            'noMatch' => false
        ]);
    } else {
        echo json_encode(['noMatch' => true]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Ошибка БД: ' . $e->getMessage()]);
}

