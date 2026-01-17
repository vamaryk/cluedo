<?php
session_start();

include 'db.php';
header('Content-Type: application/json');

$userID = $_SESSION['user_id'] ?? null;
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Не авторизован']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$gameID = (int)($data['gameID'] ?? 0);

if (!$gameID) {
    echo json_encode(['error' => 'Не указан ID игры']);
    exit;
}

try {
    // Проверяем, состоит ли пользователь в комнате
    $stmt = $pdo->prepare("SELECT 1 FROM GamePlayers WHERE GamePlayerID = ? AND PlayerUser = ?");
    $stmt->execute([$gameID, $userID]);
    if (!$stmt->fetch()) {
        echo json_encode(['error' => 'Вы не в этой комнате']);
        exit;
    }

    // Удаляем игрока из комнаты
    $stmt = $pdo->prepare("DELETE FROM GamePlayers WHERE GamePlayerID = ? AND PlayerUser = ?");
    $stmt->execute([$gameID, $userID]);

    // Если удалился хост — удаляем всю игру 
    $stmt = $pdo->prepare("SELECT GameHost FROM Games WHERE ID = ?");
    $stmt->execute([$gameID]);
    $hostID = $stmt->fetchColumn();

    if ($hostID == $userID) {
        $pdo->exec("DELETE FROM Games WHERE ID = $gameID");
    }

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Ошибка: ' . $e->getMessage()]);
}