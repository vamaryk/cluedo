<?php
session_start();

// Подключение к базе данных
require_once 'db.php';

// Получение данных из формы
$userName = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

$stmt = $pdo->prepare("SELECT * FROM users WHERE UserName = :username");
$stmt->execute(['username' => $userName]);
$user = $stmt->fetch();

if (!$user) {
    echo 'Неверное имя пользователя или пароль';
    exit;
}

if (!password_verify($password, $user['PasswordHash'])) {
    echo 'Неверное имя пользователя или пароль';
    exit;
}

// Запуск сессии и сохранение данных пользователя
$_SESSION['user_id'] = $user['ID'];
$_SESSION['username'] = $user['UserName'];

echo 'Успешный вход';
?>