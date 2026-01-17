<?php
session_start();

include 'db.php';
header('Content-Type: application/json');

$userID = $_SESSION['user_id'] ?? null;
if (!$userID) {
    http_response_code(403);
    echo json_encode(['error' => 'Не авторизован']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$gameID = (int)($data['gameID'] ?? 0);
$password = $data['password'] ?? null;

if (!$gameID) {
    echo json_encode(['error' => 'Не указан ID игры']);
    exit;
}

try {
    // Получаем данные комнаты
    $stmt = $pdo->prepare("
        SELECT ID, GamePlayersAmount, GamePrivacy, GamePasswordHash, GameStatus
        FROM Games WHERE ID = ?
    ");
    $stmt->execute([$gameID]);
    $game = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$game || $game['GameStatus'] !== 'Waiting') {
        echo json_encode(['error' => 'Комната не найдена или уже началась']);
        exit;
    }

    // Проверяем, не состоит ли уже пользователь
    $stmt = $pdo->prepare("SELECT 1 FROM GamePlayers WHERE GamePlayerID = ? AND PlayerUser = ?");
    $stmt->execute([$gameID, $userID]);
    if ($stmt->fetch()) {
        echo json_encode(['error' => 'Вы уже в этой комнате']);
        exit;
    }

    // Проверка количества игроков
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM GamePlayers WHERE GamePlayerID = ?");
    $stmt->execute([$gameID]);
    $current = (int)$stmt->fetchColumn();
    if ($current >= $game['GamePlayersAmount']) {
        echo json_encode(['error' => 'Комната заполнена']);
        exit;
    }

    // Проверка пароля для закрытой комнаты
    if ($game['GamePrivacy'] === 'Closed') {
        if (empty($password) || !password_verify($password, $game['GamePasswordHash'])) {
            echo json_encode(['error' => 'Неверный пароль']);
            exit;
        }
    }

    // Добавляем игрока
    $stmt = $pdo->prepare("INSERT INTO GamePlayers (GamePlayerID, PlayerUser) VALUES (?, ?)");
    $stmt->execute([$gameID, $userID]);

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    error_log("joinRoom error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Ошибка сервера']);
}