<?php
require 'db.php';

if (isset($_GET['roomName'])) {
    $roomName = intval($_GET['roomName']);

    $stmt = $pdo->prepare("SELECT ID FROM RoomCells WHERE RoomName = ?");
    $stmt->execute([$roomName]);
    $cells = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode($cells);
} else {
    echo json_encode(["error" => "RoomName parameter is missing"]);
}
?>
