<?php
session_start();
include '../db.php';
header('Content-Type: application/json');

$stmt = $pdo->query("
    SELECT ID, GameName, GamePlayersAmount, GamePrivacy,
           (SELECT COUNT(*) FROM GamePlayers WHERE GamePlayerID = Games.ID) AS currentPlayers
    FROM Games
    WHERE GameStatus = 'Waiting'
");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));