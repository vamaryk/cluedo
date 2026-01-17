<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $pdo->prepare("SELECT Destination FROM SecretPassages WHERE SecretPassageID = ?");
    $stmt->execute([$id]);
    $passage = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($passage) {
        echo json_encode($passage);
    } else {
        echo json_encode(["error" => "No secret passage found for ID $id"]);
    }
} else {
    echo json_encode(["error" => "ID parameter is missing"]);
}
?>
