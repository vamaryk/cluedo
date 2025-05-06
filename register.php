<?php
session_start();

// Подключение к базе данных
require_once 'db.php';

// Получение данных из формы
$userName = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// Валидация данных
if (empty($userName) || empty($email) || empty($password)) {
    echo 'Пожалуйста, заполните все поля';
    exit;
}

// Проверка существования пользователя по имени или email
$stmt = $pdo->prepare("SELECT * FROM users WHERE UserName = :username OR Email = :email");
$stmt->execute(['username' => $userName, 'email' => $email]);
$user = $stmt->fetch();

if ($user) {
    echo 'Пользователь с таким именем или email уже существует';
    exit;
}

// Хеширование пароля
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Сохранение данных в базу данных
$stmt = $pdo->prepare("
    INSERT INTO Users (UserName, Email, PasswordHash, AvatarURL, GamesPlayed, GamesWon, WrongAccusationsAmount)
    VALUES (:username, :email, :password, :avatar, :gamesPlayed, :gamesWon, :wrongAccusations)
");
$stmt->execute([
    'username' => $userName,
    'email' => $email,
    'password' => $hashedPassword,
    'avatar' => null, // Значение по умолчанию
    'gamesPlayed' => 0, // Значение по умолчанию
    'gamesWon' => 0, // Значение по умолчанию
    'wrongAccusations' => 0 // Значение по умолчанию
]);

echo 'Успешная регистрация';
?>