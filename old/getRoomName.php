<?php
require 'db.php';

header('Content-Type: application/json');

if (!isset($_GET['cellId'])) {
    http_response_code(400);
    echo json_encode(["error" => "cellId не задан"]);
    exit();
}

$cellId = (int)$_GET['cellId'];

try {
    $stmt = $pdo->prepare("SELECT RoomName FROM RoomCells WHERE ID = ?");
    $stmt->execute([$cellId]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($room) {
        echo json_encode(["RoomName" => $room["RoomName"]]);
    } else {
        echo json_encode(["RoomName" => null]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Ошибка выполнения запроса: " . $e->getMessage()]);
}

