<?php
session_start();

include 'db.php';
header('Content-Type: application/json');

$gameID = (int)($_GET['gameID'] ?? 0);
if (!$gameID) {
    http_response_code(400);
    echo json_encode(['error' => 'Нет gameID']);
    exit;
}

try {
    // Данные комнаты
    $stmt = $pdo->prepare("
        SELECT GameName, GameHost, GamePlayersAmount, GameStatus
        FROM Games WHERE ID = ?
    ");
    $stmt->execute([$gameID]);
    $game = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$game) {
        echo json_encode(['error' => 'Игра удалена', 'deleted' => true]);
        exit;
    }

    // Игроки
    $stmt = $pdo->prepare("
        SELECT u.ID, u.UserName, u.AvatarURL
        FROM GamePlayers gp
        JOIN Users u ON gp.PlayerUser = u.ID
        WHERE gp.GamePlayerID = ?
        ORDER BY u.ID
    ");
    $stmt->execute([$gameID]);
    $players = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'game' => $game,
        'players' => $players,
        'isHost' => ($game['GameHost'] == $_SESSION['user_id'] ?? null)
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}