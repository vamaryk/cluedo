<?php
session_start();
echo "Файл redirectToGame.php загружен<br>";

// Проверка, авторизован ли пользователь
if (isset($_SESSION['user_id'])) {
    echo "Пользователь авторизован: {$_SESSION['user_id']}<br>";
    header('Location: Cluedo (с ботами). New.php');
    exit;
} else {
    echo "Пользователь НЕ авторизован<br>";
    header('Location: index.php');
    exit;
}


