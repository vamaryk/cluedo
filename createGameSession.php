<?php
include 'db.php';

header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['playerID']) || !isset($data['bots']) || !is_array($data['bots'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Неверные данные']);
    exit;
}

$humanPlayerID = $data['playerID'];
$botIDs = array_values(array_unique($data['bots'])); // Удаление дубликатов

// Исключаем игрока из списка ботов
$botIDs = array_diff($botIDs, [$humanPlayerID]);

try {
    $pdo->beginTransaction();

    // --- 1. Выбор карт для решения ---
    $types = ['Character', 'Weapon', 'Room'];
    $solution = [];

    foreach ($types as $type) {
        $stmt = $pdo->prepare("SELECT ID FROM Cards WHERE CardType = ? ORDER BY RAND() LIMIT 1");
        $stmt->execute([$type]);
        $result = $stmt->fetchColumn();
        if (!$result) throw new Exception("Нет карт для типа: $type");
        $solution[$type] = $result;
    }

    // --- Проверка уникальности карт решения ---
    $solutionIDs = array_values($solution);
    if (count(array_unique($solutionIDs)) !== 3) {
        throw new Exception("Карты решения не уникальны");
    }

    // --- 2. Вставка новой игры ---
    $stmt = $pdo->prepare("INSERT INTO Games 
        (GameHost, GameName, GamePlayersAmount, SolutionCharacter, SolutionWeapon, SolutionRoom) 
        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $humanPlayerID,
        "Game_" . uniqid(),
        5, // Всегда 5 игроков
        $solution['Character'],
        $solution['Weapon'],
        $solution['Room']
    ]);
    $gameID = $pdo->lastInsertId();

    // --- 3. Очистка GameCards для всех игроков текущей игры ---
    $players = array_merge([$humanPlayerID], $botIDs);
    if (count($players) !== 5) {
        throw new Exception("Должно быть ровно 5 игроков");
    }

    $placeholders = implode(',', array_fill(0, 5, '?')); // 5 вопросительных знаков
    $stmt = $pdo->prepare("DELETE FROM GameCards WHERE CardPlayer IN ($placeholders)");
    $stmt->execute($players);

    // --- 4. Получение оставшихся карт ---
    $stmt = $pdo->prepare("SELECT ID FROM Cards WHERE ID NOT IN (?, ?, ?)");
    $stmt->execute([$solution['Character'], $solution['Weapon'], $solution['Room']]);
    $remainingCards = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $remainingCards = array_unique($remainingCards); // Удаление дубликатов
    shuffle($remainingCards); // Перемешивание карт

    // --- 5. Распределение карт между 5 игроками ---
    $chunkedCards = array_chunk($remainingCards, ceil(count($remainingCards) / 5));
    $cardsPerPlayer = [];

    for ($i = 0; $i < 5; $i++) {
        $cardsPerPlayer[$i] = $chunkedCards[$i] ?? [];
    }

    // --- 6. Вставка карт в GameCards (без дубликатов) ---
    $stmtCheck = $pdo->prepare("SELECT 1 FROM GameCards WHERE CardPlayer = ? AND CardName = ?");
    $stmtInsert = $pdo->prepare("INSERT IGNORE INTO GameCards (CardPlayer, CardName) VALUES (?, ?)");

    $allAssignedCards = []; // Массив для отслеживания всех назначенных карт

    foreach ($players as $playerIndex => $currentPlayerID) {
        foreach ($cardsPerPlayer[$playerIndex] as $cardID) {
            if (!in_array($cardID, $allAssignedCards)) { // Проверяем, была ли карта уже назначена
                $stmtCheck->execute([$currentPlayerID, $cardID]);
                if (!$stmtCheck->fetch()) {
                    $stmtInsert->execute([$currentPlayerID, $cardID]);
                    $allAssignedCards[] = $cardID; // Добавляем карту в массив назначенных карт
                }
            }
        }
    }

    // --- 7. Получение карт реального игрока ---
    $stmt = $pdo->prepare("SELECT c.ID, c.CardName, c.CardImageURL 
                           FROM GameCards gc
                           JOIN Cards c ON gc.CardName = c.ID
                           WHERE gc.CardPlayer = ?");
    $stmt->execute([$humanPlayerID]);
    $playerCards = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $pdo->commit();

    // --- 8. Ответ клиенту ---
    echo json_encode([
        'gameID' => $gameID,
        'playerCards' => array_map(fn($card) => [
            'id' => $card['ID'],
            'name' => $card['CardName'],
            'image' => $card['CardImageURL']
        ], $playerCards)
    ]);

} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Ошибка БД: ' . $e->getMessage()]);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => 'Ошибка: ' . $e->getMessage()]);
}
?>