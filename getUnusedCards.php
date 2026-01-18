<?php
include 'db.php';

header('Content-Type: application/json; charset=utf-8');

try {
    // 1. Все карты
    $allCards = $pdo->query("SELECT ID, CardName FROM Cards")->fetchAll(PDO::FETCH_ASSOC);

    // 2. Карты у игроков
    $dealt = $pdo->query("SELECT CardName FROM GameCards")->fetchAll(PDO::FETCH_COLUMN);

    // 3. Карты решения
    $solution = $pdo->query("
        SELECT SolutionCharacter, SolutionWeapon, SolutionRoom 
        FROM Games 
        ORDER BY ID DESC LIMIT 1
    ")->fetch(PDO::FETCH_ASSOC);

    $solutionCards = array_values($solution);

    // 4. Исключение
    $used = array_merge($dealt, $solutionCards);

    $unused = array_filter($allCards, function ($card) use ($used) {
        return !in_array($card['ID'], $used);
    });

    echo json_encode([
        'success' => true,
        'unusedCards' => array_values($unused)
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
