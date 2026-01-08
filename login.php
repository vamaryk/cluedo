<?php
session_start();
header('Content-Type: application/json'); // Устанавливаем заголовок для JSON ответа

// Подключение к базе данных
require_once 'db.php';

// Получение данных из формы
$userName = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

$response = [];

if (empty($userName) || empty($password)) {
    $response = ['success' => false, 'error_type' => 'general', 'message' => 'Пожалуйста, заполните все поля.'];
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE UserName = :username");
$stmt->execute(['username' => $userName]);
$user = $stmt->fetch();

// Проверка учетных данных
if (!$user || !password_verify($password, $user['PasswordHash'])) {
    // Возвращаем общую ошибку, чтобы не раскрывать, существует ли пользователь
    $response = ['success' => false, 'error_type' => 'credentials', 'message' => 'Неверное имя пользователя или пароль'];
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

// Запуск сессии и сохранение данных пользователя
$_SESSION['user_id'] = $user['ID'];
$_SESSION['username'] = $user['UserName'];

$response = ['success' => true, 'message' => 'Успешный вход'];
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>