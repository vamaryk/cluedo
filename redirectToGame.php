<?php
session_start();
echo "Файл redirectToGame.php загружен<br>";

// Проверка, авторизован ли пользователь
if (isset($_SESSION['user_id'])) {
    echo "Пользователь авторизован: {$_SESSION['user_id']}<br>";
<<<<<<< HEAD
    header('Location: rooms.php');
    // header('Location: Cluedo (с ботами). New2.php');
=======
    header('Location: CluedoGameOffline.php');
>>>>>>> 698c8081f17b602c8733a8473553ac0103640c70
    exit;
} else {
    echo "Пользователь НЕ авторизован<br>";
    header('Location: index.php');
    exit;
}



