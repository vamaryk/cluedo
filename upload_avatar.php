<?php
session_start();
header('Content-Type: application/json');

// Подключение к базе данных
require_once 'db.php';

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Ошибка авторизации.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$upload_dir = 'uploads/avatars/';
$default_avatar = 'uploads/avatars/default-avatar.png';

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Файл не был загружен или произошла ошибка.']);
    exit;
}

$file = $_FILES['avatar'];
$max_size = 2 * 1024 * 1024; // Макс. 2MB

// 1. Проверка размера
if ($file['size'] > $max_size) {
    echo json_encode(['success' => false, 'message' => 'Файл слишком большой (макс. 2MB).']);
    exit;
}

// 2. Проверка типа MIME (для безопасности)
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime_type = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($mime_type, $allowed_types)) {
    echo json_encode(['success' => false, 'message' => 'Недопустимый тип файла. Разрешены только JPG, PNG, GIF.']);
    exit;
}

// 3. Генерация уникального имени файла
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
// Используем ID пользователя и метку времени для уникальности
$filename = $user_id . '_' . time() . '.' . $extension;
$target_path = $upload_dir . $filename;
$avatar_url = $target_path; // Путь для сохранения в БД

// 4. Получение старого аватара для удаления
$stmt = $pdo->prepare("SELECT AvatarURL FROM Users WHERE ID = :id");
$stmt->execute(['id' => $user_id]);
$old_avatar_url = $stmt->fetchColumn();

// 5. Перемещение файла
if (move_uploaded_file($file['tmp_name'], $target_path)) {
    
    // 6. Обновление БД
    $stmt = $pdo->prepare("UPDATE Users SET AvatarURL = :avatar_url WHERE ID = :id");
    if ($stmt->execute(['avatar_url' => $avatar_url, 'id' => $user_id])) {
        
        // 7. Удаление старого файла, если он существует и не является дефолтным
        if ($old_avatar_url && $old_avatar_url !== $default_avatar && file_exists($old_avatar_url)) {
            unlink($old_avatar_url);
        }
        
        echo json_encode(['success' => true, 'message' => 'Аватар обновлен.', 'new_avatar_url' => $avatar_url]);
    } else {
        // Если БД не обновилась, удаляем загруженный файл
        unlink($target_path);
        echo json_encode(['success' => false, 'message' => 'Ошибка сохранения пути в базе данных.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Не удалось сохранить файл на сервере.']);
}
?>