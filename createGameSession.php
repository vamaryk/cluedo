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

// Исключает игрока из списка ботов
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

    // --- 2. Игроки новой игры ---
    $players = array_merge([$humanPlayerID], $botIDs);
    $playerCount = count($players); // Динамическое количество игроков
    if ($playerCount < 3) {
      throw new Exception("Должно быть минимум 3 игрока");
    }

    // --- 2.1. Вставка новой игры в БД---
    $stmt = $pdo->prepare("INSERT INTO Games 
        (GameHost, GameName, GamePlayersAmount, SolutionCharacter, SolutionWeapon, SolutionRoom) 
        VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $humanPlayerID,
        "Game_" . uniqid(),
        $playerCount,
        $solution['Character'],
        $solution['Weapon'],
        $solution['Room']
    ]);
    $gameID = $pdo->lastInsertId();

    // --- 3. Очистка GameCards для всех игроков текущей игры ---
    $allPossiblePlayers = range(1, 5); // Всегда 5 игроков с ID от 1 до 5
    $placeholders = implode(',', array_fill(0, count($allPossiblePlayers), '?'));
    $stmt = $pdo->prepare("DELETE FROM GameCards WHERE CardPlayer IN ($placeholders)");
    $stmt->execute($allPossiblePlayers);

    // --- 4. Получение оставшихся карт ---
    $stmt = $pdo->prepare("SELECT ID FROM Cards WHERE ID NOT IN (?, ?, ?)");
    $stmt->execute([$solution['Character'], $solution['Weapon'], $solution['Room']]);
    $remainingCards = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $remainingCards = array_unique($remainingCards); // Удаление дубликатов
    shuffle($remainingCards); // Перемешивание карт

    // --- 5. Распределение карт между игроками ---
    $cardsPerPlayer = array_fill(0, $playerCount, []); // Инициализация пустых массивов для каждого игрока
    $cardsPerPlayerCount = floor(count($remainingCards) / $playerCount); // Сколько карт получит каждый игрок
    $totalCardsToDistribute = $cardsPerPlayerCount * $playerCount; // Общее количество карт, которые будут распределены
    $cardsToDistribute = array_slice($remainingCards, 0, $totalCardsToDistribute);
    foreach ($cardsToDistribute as $index => $cardID) {
        $playerIndex = $index % $playerCount; // Распределяет циклически по игрокам
        $cardsPerPlayer[$playerIndex][] = $cardID;
    }

    // --- 6. Вставка карт в GameCards (без дубликатов) ---
    $stmtCheck = $pdo->prepare("SELECT 1 FROM GameCards WHERE CardPlayer = ? AND CardName = ?");
    $stmtInsert = $pdo->prepare("INSERT IGNORE INTO GameCards (CardPlayer, CardName) VALUES (?, ?)");
    $allAssignedCards = []; // Массив для отслеживания всех назначенных карт
    foreach ($players as $playerIndex => $currentPlayerID) {
        foreach ($cardsPerPlayer[$playerIndex] as $cardID) {
            if (!in_array($cardID, $allAssignedCards)) { // Проверяет, была ли карта уже назначена
                $stmtCheck->execute([$currentPlayerID, $cardID]);
                if (!$stmtCheck->fetch()) {
                    $stmtInsert->execute([$currentPlayerID, $cardID]);
                    $allAssignedCards[] = $cardID; // Добавляет карту в массив назначенных карт
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