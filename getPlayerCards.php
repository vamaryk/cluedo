<?php
include 'db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$playerID = $data['playerID'];

try {
    $stmt = $pdo->prepare("SELECT c.ID AS id, c.Name AS name, c.Image AS image 
                           FROM GameCards gc 
                           JOIN Cards c ON gc.CardName = c.ID 
                           WHERE gc.CardPlayer = :playerID");
    $stmt->execute(['playerID' => $playerID]);
    $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'cards' => $cards]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
