<?php
session_start();

include 'db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Не авторизован']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$userID = $data['userID'] ?? null;
$gameName = trim($data['gameName'] ?? '');
$privacy = $data['privacy'] ?? 'Open';
$password = $data['password'] ?? null;
$players = (int)($data['players'] ?? 3);

if (!$userID || !in_array($players, [2,3,4,5])) {
    http_response_code(400);
    echo json_encode(['error' => 'Неверные данные']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Хешируем пароль, если комната приватная
    $passwordHash = null;
    if ($privacy === 'Closed') {
        if (empty($password)) throw new Exception('Требуется пароль');
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }

    $stmt = $pdo->prepare("
        INSERT INTO Games 
        (GameHost, GameName, GamePlayersAmount, GamePrivacy, GamePasswordHash, GameStatus)
        VALUES (?, ?, ?, ?, ?, 'Waiting')
    ");
    $stmt->execute([
        $userID,
        $gameName ?: ('Room_' . uniqid()),
        $players,
        $privacy,
        $passwordHash
    ]);

    $gameID = $pdo->lastInsertId();

    // Добавляем хоста как первого игрока
    $stmt = $pdo->prepare("INSERT INTO GamePlayers (GamePlayerID, PlayerUser) VALUES (?, ?)");
    $stmt->execute([$gameID, $userID]);

    $pdo->commit();

    echo json_encode(['gameID' => $gameID]);

} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}