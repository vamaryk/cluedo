<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once 'db.php';
$current_user_id = $_SESSION['user_id'];

// --- ЗАПРОС К БД ---
$stmt = $pdo->prepare("
    SELECT 
        u.ID, 
        u.UserName, 
        u.AvatarURL,
        f_out.FriendStatus AS Status_Out, 
        f_in.FriendStatus AS Status_In
    FROM Users u
    
    LEFT JOIN Friends f_out 
        ON f_out.Friend = :current_id AND f_out.FriendOwner = u.ID
        
    LEFT JOIN Friends f_in
        ON f_in.Friend = u.ID AND f_in.FriendOwner = :current_id
        
    WHERE u.ID != :current_id
    ORDER BY u.UserName
");
$stmt->execute(['current_id' => $current_user_id]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пользователи | Cluedo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .users-list-container {
            padding: 2em 4em;
            margin: 0 2em;
            color: #FAFAFA;
        }
        .user-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 12px;
            border: solid 2px #FAFAFA;
        }
        .user-info {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            overflow: hidden;
            margin-right: 15px;
        }
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .user-actions {
            display: flex;
            gap: .9em;
            align-items: center;
        }

        .user-actions button, .user-actions a {
            padding: 10px;
            height: 40px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        .user-actions button i, 
        .user-actions a i {
            margin-right: 5px;
        }
        .btn-message i {
            margin-right: 0;
        }

        .btn-add { background-color: #007bff; }
        .btn-add:hover { background-color: #0056b3; }
        .btn-message { background-color: #14b136ff; }
        .btn-message:hover { background-color: #1e7e34; }
        .btn-block { background-color: #dc3545; }
        .btn-block:hover { background-color: #bd2130; }
        .btn-unblock { background-color: #ffc107; color: #333; }
        .btn-unblock:hover { background-color: #e0a800; }
        
        .status-text {
            margin-left: 10px;
            font-weight: bold;
        }
        .status-blocked-by-me {
            color: #dc3545;
        }
        .status-blocked-by-them {
            color: #ffc107;
        }
    </style>
</head>
<body>
    <div class="gradient"></div>
    <nav class="navbar navbar-expand-lg navbar-light rounded-[20px] p-3">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav gap-2">
                    <li class="nav-item">
                        <a class="nav-link" href="redirectToGame.php"><i class="fa fa-home"></i> комнаты</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Ссылки для авторизованных пользователей -->
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa fa-comments"></i> чат</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php"><i class="fa fa-user"></i> профиль</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link current" href="users.php"><i class="fa fa-user"></i> пользователи</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link"  href="rules.php"><i class="fa fa-book"></i> правила</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-cog"></i> настройки</a>
                    </li>
                </ul>
            </div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Ссылка для авторизованных пользователей -->
                <a class="btn" href="logout.php"><i class="fa fa-sign-out"></i></a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="users-list-container">
        <h1>Список пользователей</h1>
        <div id="statusMessage" style="margin-bottom: 15px;"></div>

        <?php if (empty($users)): ?>
            <p>В системе нет других пользователей.</p>
        <?php else: ?>
            <?php foreach ($users as $user): 
                $avatar_src = htmlspecialchars($user['AvatarURL'] ?? 'default-avatar.png');
                
                $status_out = $user['Status_Out']; // Статус, который я установил (Я Инициатор)
                $status_in = $user['Status_In'];   // Статус, который они установили (Я Цель)

                // Определяем, кто кого заблокировал
                $i_blocked_him = ($status_out === 'Blocked');
                $he_blocked_me = ($status_in === 'Blocked');

                // Кнопка "Разблокировать" показывается ТОЛЬКО, если я его заблокировал
                $is_blocked_by_me = $i_blocked_him; 
                
                // Сообщение отключено, если заблокировал я ИЛИ заблокировал он
                $can_message = !($i_blocked_him || $he_blocked_me);
            ?>
                <div class="user-card" data-user-id="<?php echo $user['ID']; ?>">
                    <div class="user-info">
                        <div class="user-avatar">
                            <img src="<?php echo $avatar_src; ?>" alt="Аватар">
                        </div>
                        <span><?php echo htmlspecialchars($user['UserName']); ?></span>
                        <span class="status-text" id="status-<?php echo $user['ID']; ?>">
                            <?php 
                                // Логика отображения статуса
                                if ($i_blocked_him && $he_blocked_me) {
                                    echo '<span class="status-blocked-by-me">(Взаимная блокировка)</span>';
                                } elseif ($i_blocked_him) {
                                    echo '<span class="status-blocked-by-me">(Заблокирован вами)</span>';
                                } elseif ($he_blocked_me) {
                                    echo '<span class="status-blocked-by-them">(Заблокировал вас)</span>';
                                }
                            ?>
                        </span>
                    </div>
                    <div class="user-actions">
                        
                        <!-- Кнопка "Добавить в друзья" (пока не реализована) -->
                        <button class="btn-add btn-friend" data-action="add">
                            <span><i class="fa fa-user-plus"></i> Добавить в друзья</span>
                        </button>

                        <!-- Кнопка "Написать сообщение" -->
                        <a href="#" class="btn-message" 
                           title="Написать сообщение" 
                           data-action="message"
                           <?php echo !$can_message ? 'style="opacity: 0.5; pointer-events: none;"' : ''; ?>
                        >
                            <i class="fa fa-comments"></i>
                        </a>

                        <!-- Кнопка "Блокировать/Разблокировать" -->
                        <button class="btn-toggle-block <?php echo $is_blocked_by_me ? 'btn-unblock' : 'btn-block'; ?>" 
                                data-action="<?php echo $is_blocked_by_me ? 'unblock' : 'block'; ?>"
                                data-target-id="<?php echo $user['ID']; ?>"
                                id="block-btn-<?php echo $user['ID']; ?>"
                        >
                            <i class="fa fa-ban"></i>
                            <span class="btn-text"><?php echo $is_blocked_by_me ? 'Разблокировать' : 'Заблокировать'; ?></span>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function showStatus(message, isError = false) {
                const $msg = $('#statusMessage');
                $msg.html(`<div class="alert alert-${isError ? 'danger' : 'success'}">${message}</div>`);
                setTimeout(() => $msg.empty(), 5000);
            }

            $('.btn-toggle-block').on('click', function() {
                const $button = $(this);
                const targetId = $button.data('target-id');
                const action = $button.data('action');

                $button.prop('disabled', true);

                $.ajax({
                    url: 'block_user.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        target_id: targetId,
                        action: action
                    },
                    success: function(response) {
                        $button.prop('disabled', false);

                        if (response.success) {
                            const $messageLink = $button.siblings('.btn-message');
                            const $statusTextContainer = $(`#status-${targetId}`);
                            
                            // Получаем статус, который установил ОН для МЕНЯ
                            const he_still_blocks_me = response.new_status_in === 'Blocked';

                            if (action === 'block') {
                                // --- Я ЗАБЛОКИРОВАЛ ЕГО (Я Инициатор) ---
                                $button.data('action', 'unblock').removeClass('btn-block').addClass('btn-unblock');
                                $button.find('.btn-text').text('Разблокировать');
                                
                                $messageLink.css({'opacity': '0.5', 'pointer-events': 'none'});
                                
                                // Устанавливаем статус
                                if (he_still_blocks_me) {
                                    $statusTextContainer.html('<span class="status-blocked-by-me">(Взаимная блокировка)</span>');
                                } else {
                                    $statusTextContainer.html('<span class="status-blocked-by-me">(Заблокирован вами)</span>');
                                }
                                showStatus(response.message);
                                
                            } else {
                                // --- Я РАЗБЛОКИРОВАЛ ЕГО (Я Снял свою блокировку) ---
                                $button.data('action', 'block').removeClass('btn-unblock').addClass('btn-block');
                                $button.find('.btn-text').text('Заблокировать');
                                
                                if (he_still_blocks_me) {
                                    $messageLink.css({'opacity': '0.5', 'pointer-events': 'none'});
                                    
                                    $statusTextContainer.html('<span class="status-blocked-by-them">(Заблокировал вас)</span>');
                                    
                                } else {
                                    $messageLink.css({'opacity': '', 'pointer-events': ''});
                                    $statusTextContainer.empty(); 
                                }
                                showStatus(response.message);
                            }
                        } else {
                            showStatus('Ошибка: ' + response.message, true);
                            $button.prop('disabled', false); // В случае ошибки возвращаем кнопку
                        }
                    },
                    error: function() {
                        $button.prop('disabled', false);
                        showStatus('Ошибка сети или сервера.', true);
                    }
                });
            });
        });
    </script>
</body>
</html>