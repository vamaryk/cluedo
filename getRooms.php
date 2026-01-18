<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

$stmt = $pdo->query("
    SELECT 
        g.ID AS gameID,
        g.GameName,
        g.GamePlayersAmount,
        g.GameStatus,
        g.GamePrivacy,
        COUNT(gp.PlayerUser) AS currentPlayers
    FROM Games g
    LEFT JOIN GamePlayers gp ON g.ID = gp.GamePlayerID
    WHERE g.GameStatus = 'Waiting'
    GROUP BY g.ID
    ORDER BY g.ID DESC
");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($rooms);