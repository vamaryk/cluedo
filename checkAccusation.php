<?php
include 'db.php';

header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['selectedCards']) || !is_array($data['selectedCards']) || count($data['selectedCards']) !== 3) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Некорректные данные']);
    exit;
}

$selectedCards = $data['selectedCards'];

try {
    // Получаем данные последней игры
    $stmt = $pdo->query("SELECT SolutionCharacter, SolutionWeapon, SolutionRoom FROM Games ORDER BY ID DESC LIMIT 1");
    $solution = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$solution) {
        throw new Exception("Решение не найдено");
    }

    $solutionCards = [
        $solution['SolutionCharacter'],
        $solution['SolutionWeapon'],
        $solution['SolutionRoom']
    ];

    // Сравниваем массивы
    $isCorrect = !array_diff($solutionCards, $selectedCards) && !array_diff($selectedCards, $solutionCards);

    echo json_encode(['success' => $isCorrect]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Ошибка сервера: ' . $e->getMessage()]);
}
?>
