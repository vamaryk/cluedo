<?php
session_start();
header('Content-Type: application/json');

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Требуется авторизация.']);
    exit;
}

require_once 'db.php';
$current_user_id = $_SESSION['user_id'];

$target_id = filter_input(INPUT_POST, 'target_id', FILTER_VALIDATE_INT);
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$response = ['success' => false, 'message' => 'Неизвестная ошибка.', 'new_status_in' => 'None'];

if (!$target_id || ($action !== 'block' && $action !== 'unblock')) {
    $response['message'] = 'Неверные данные запроса.';
    echo json_encode($response);
    exit;
}

// Инициатор = Friend, Цель = FriendOwner
$SenderID = $current_user_id;
$ReceiverID = $target_id;

try {
    $pdo->beginTransaction();

    if ($action === 'block') {
        // 1. Вставляем или обновляем запись, где Я блокирую ЕГО
        $stmt = $pdo->prepare("
            INSERT INTO Friends (Friend, FriendOwner, FriendStatus) 
            VALUES (:sender, :receiver, 'Blocked')
            ON DUPLICATE KEY UPDATE FriendStatus = 'Blocked'
        ");
        $stmt->execute(['sender' => $SenderID, 'receiver' => $ReceiverID]);
        
        // 2. Удаляем симметричную запись, если она была (например, дружба)
        $stmt = $pdo->prepare("
            DELETE FROM Friends 
            WHERE Friend = :receiver AND FriendOwner = :sender AND FriendStatus != 'Blocked'
        ");
        $stmt->execute(['sender' => $SenderID, 'receiver' => $ReceiverID]);

        $response['success'] = true;
        $response['message'] = 'Пользователь успешно заблокирован.';

    } elseif ($action === 'unblock') {
        // Разблокировать можно только ту запись, которую создал сам (Я Инициатор)
        $stmt = $pdo->prepare("
            DELETE FROM Friends 
            WHERE Friend = :sender AND FriendOwner = :receiver AND FriendStatus = 'Blocked'
        ");
        $stmt->execute(['sender' => $SenderID, 'receiver' => $ReceiverID]);
        
        if ($stmt->rowCount() > 0) {
            $response['success'] = true;
            $response['message'] = 'Пользователь успешно разблокирован.';
        } else {
            $response['success'] = false;
            $response['message'] = 'Пользователь не был заблокирован вами.';
        }
    }
    
    $pdo->commit();
    
    // --- ПРОВЕРКА СТАТУСА ПОСЛЕ ДЕЙСТВИЯ ---
    
    // Проверяем, блокирует ли нас целевой пользователь (Он -> Я)
    $stmt_check = $pdo->prepare("
        SELECT FriendStatus FROM Friends 
        WHERE Friend = :receiver AND FriendOwner = :sender AND FriendStatus = 'Blocked'
    ");
    $stmt_check->execute(['receiver' => $ReceiverID, 'sender' => $SenderID]);
    $status_in = $stmt_check->fetchColumn();
    
    // Если найдена запись о блокировке нас, возвращаем 'Blocked', иначе 'None'
    $response['new_status_in'] = $status_in ? 'Blocked' : 'None';

} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Block/Unblock Error: " . $e->getMessage());
    $response['message'] = 'Ошибка базы данных при выполнении операции.';
}

echo json_encode($response);
?>