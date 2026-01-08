<?php
session_start();
header('Content-Type: application/json'); // Устанавливаем заголовок для JSON ответа

// Подключение к базе данных
require_once 'db.php';

// Получение данных из формы
$userName = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

$response = ['success' => false];

// 1. Валидация на пустые поля
if (empty($userName)) {
    $response['field'] = 'username';
    $response['message'] = 'Имя пользователя не может быть пустым.';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}
if (empty($email)) {
    $response['field'] = 'email';
    $response['message'] = 'Email не может быть пустым.';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}
if (empty($password)) {
    $response['field'] = 'password';
    $response['message'] = 'Пароль не может быть пустым.';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

// 2. Проверка существования пользователя по имени или email
$stmt = $pdo->prepare("SELECT UserName, Email FROM users WHERE UserName = :username OR Email = :email");
$stmt->execute(['username' => $userName, 'email' => $email]);
$existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existingUser) {
    if ($existingUser['UserName'] === $userName) {
        $response['field'] = 'username';
        $response['message'] = 'Это имя пользователя уже занято.';
    } elseif ($existingUser['Email'] === $email) {
        $response['field'] = 'email';
        $response['message'] = 'Пользователь с таким email уже зарегистрирован.';
    }
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}

// Хеширование пароля
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$default_avatar = 'uploads/avatars/default_avatar.png';

// Сохранение данных в базу данных
try {
    $stmt = $pdo->prepare("
        INSERT INTO Users (UserName, Email, PasswordHash, AvatarURL, GamesPlayed, GamesWon, WrongAccusationsAmount)
        VALUES (:username, :email, :password, :avatar, :gamesPlayed, :gamesWon, :wrongAccusations)
    ");
    $stmt->execute([
        'username' => $userName,
        'email' => $email,
        'password' => $hashedPassword,
        'avatar' => $default_avatar, // Значение по умолчанию
        'gamesPlayed' => 0, // Значение по умолчанию
        'gamesWon' => 0, // Значение по умолчанию
        'wrongAccusations' => 0 // Значение по умолчанию
    ]);

    $response['success'] = true;
    $response['message'] = 'Успешная регистрация';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    $response['success'] = false;
    $response['field'] = 'general';
    $response['message'] = 'Ошибка базы данных при регистрации.';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
?>