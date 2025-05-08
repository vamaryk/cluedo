<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $pdo->prepare("SELECT ChipCharacter FROM Chips WHERE ID = ?");
    $stmt->execute([$id]);
    $chip = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($chip) {
        echo json_encode($chip);
    } else {
        echo json_encode(["error" => "Chip with ID $id not found"]);
    }
} else {
    echo json_encode(["error" => "ID parameter is missing"]);
}
?>
