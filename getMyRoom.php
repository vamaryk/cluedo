<?php
session_start();
include 'db.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Не авторизован']);
    exit;
}

$userID = $_SESSION['user_id'];

try {
    // Получение активной комнаты, пользователь является хостом
    $stmt = $pdo->prepare("
        SELECT 
            g.ID AS gameID,
            g.GameName,
            g.GamePrivacy,
            g.GamePlayersAmount,
            COUNT(gp.PlayerUser) AS currentPlayers
        FROM Games g
        LEFT JOIN GamePlayers gp ON g.ID = gp.GamePlayerID
        WHERE g.GameHost = ? AND g.GameStatus = 'Waiting'
        GROUP BY g.ID
        LIMIT 1
    ");
    $stmt->execute([$userID]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($room) {
        echo json_encode([
            'exists' => true,
            'gameID' => (int)$room['gameID'],
            'name' => $room['GameName'],
            'privacy' => $room['GamePrivacy'] === 'Open' ? 'открытый' : 'закрытый',
            'maxPlayers' => (int)$room['GamePlayersAmount'],
            'currentPlayers' => (int)$room['currentPlayers']
        ]);
    } else {
        echo json_encode(['exists' => false]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Ошибка сервера']);
}