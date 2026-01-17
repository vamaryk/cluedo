<?php
require 'db.php';

try {
    $stmt = $pdo->query("SELECT ID, ChipDefaultCoordinateX, ChipDefaultCoordinateY FROM Chips");
    $chips = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($chips);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
