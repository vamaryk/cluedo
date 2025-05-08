<?php
require 'db.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT ID, RoomName, CellCoordinateX, CellCoordinateY FROM RoomCells");
    $cells = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($cells);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Ошибка выполнения запроса: " . $e->getMessage()]);
}



