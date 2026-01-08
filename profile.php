<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Подключение к базе данных
require_once 'db.php';

$stmt = $pdo->prepare("SELECT * FROM Users WHERE ID = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    header('Location: logout.php');
    exit;
}

// Установим дефолтный аватар, если в БД пусто
$avatar_src = htmlspecialchars($user['AvatarURL'] ?? 'default-avatar.png');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль | Cluedo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Дополнительные стили для функционала загрузки аватара */
        .avatar-wrapper {
            position: relative;
            display: inline-block;
            border-radius: 20px;
            overflow: hidden;
            width: 150px;
            height: 150px;
        }
        
        .avatar-wrapper .avatar {
            width: 100%;
            height: 100%;
            display: flex; 
            justify-content: center; 
            align-items: center; 
        }
        
        .avatar-wrapper .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .avatar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s;
            cursor: pointer;
            color: white;
            font-size: 14px;
        }
        .avatar-wrapper:hover .avatar-overlay {
            opacity: 1;
        }
        .avatar-overlay i {
            font-size: 24px;
            margin-bottom: 5px;
        }
        #avatarMessage {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="gradient"></div>
    <audio id="background-music" src="./audio/background-music.mp3" loop></audio>

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
                            <a class="nav-link current" href="profile.php"><i class="fa fa-user"></i> профиль</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="users.php"><i class="fa fa-user"></i> пользователи</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="rules.php"><i class="fa fa-book"></i> правила</a>
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
    <div class="profile-container">
        <!-- Левая панель -->
        <div class="left-panel">
            
            <!-- Обновленный блок аватара с возможностью загрузки -->
            <div class="avatar-wrapper">
                <div class="avatar">
                    <img id="profileAvatar" src="<?php echo $avatar_src; ?>" alt="Аватар">
                    <label for="avatarUpload" class="avatar-overlay" title="Изменить фото">
                        <i class="fa fa-camera"></i>
                        <span>Изменить</span>
                    </label>
                </div>
            </div>
            <input type="file" id="avatarUpload" name="avatar" accept="image/jpeg, image/png, image/gif" style="display: none;">
            <div id="avatarMessage"></div>
            <!-- Конец обновленного блока -->

            <h3><?php echo htmlspecialchars($user['UserName']); ?></h3>
            <p><?php echo htmlspecialchars($user['Email']); ?></p>
            <div class="stats">
                <div class="stat-item">сыграно <br><strong><?php echo htmlspecialchars($user['GamesPlayed']); ?></strong></div>
                <div class="stat-item">побед <br><strong><?php echo htmlspecialchars($user['GamesWon']); ?></strong></div>
                <div class="stat-item">ложных обвинений <br><strong><?php echo htmlspecialchars($user['WrongAccusationsAmount']); ?></strong></div>
            </div>
        </div>

        <!-- Правая панель -->
        <div class="right-panel">
            <h2>созданная комната</h2>
            <div class="room-info">
                <p style="text-align: center; margin-top: 10px;">Хроники Улик</p>
                <div class="room-cont">
                    <p><strong>Доступ:</strong> открытый</p>
                    <p><strong>Кол-во игроков:</strong> 4</p>
                    <p><strong>Подключено:</strong> 0</p>
                </div>
            </div>

            <h2>друзья</h2>
            <div class="friends-list">
                <div class="friend-card">
                    <div class="fr_avatar"><img src="" alt="Аватар"></div>
                    <div>
                        <strong>Leo</strong>
                        <div class="actions">
                            <span class="action-btn">удалить</span>
                            <span class="action-btn">написать</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Функция для воспроизведения музыки
        function playBackgroundMusic() {
            const audio = document.getElementById('background-music');
            if (audio) {
                audio.volume = 0.5;
                audio.play().catch(error => {
                    console.error('Не удалось воспроизвести музыку:', error);
                });
            }
        }

        window.onload = function () {
            playBackgroundMusic();
        };

        // --- Функционал загрузки аватара ---

        document.getElementById('avatarUpload').addEventListener('change', function() {
            if (this.files.length > 0) {
                uploadAvatar(this.files[0]);
            }
        });

        function uploadAvatar(file) {
            const formData = new FormData();
            formData.append('avatar', file);

            $.ajax({
                url: 'upload_avatar.php',
                type: 'POST',
                data: formData,
                processData: false, // Обязательно для загрузки файлов
                contentType: false, // Обязательно для загрузки файлов
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Обновляем src изображения, добавляя метку времени, чтобы браузер не использовал кэш
                        $('#profileAvatar').attr('src', response.new_avatar_url + '?' + new Date().getTime()); 
                    } else {
                        $('#avatarMessage').html('<span style="color: red;">Ошибка: ' + response.message + '</span>');
                    }
                },
                error: function() {
                    $('#avatarMessage').html('<span style="color: red;">Ошибка сервера при загрузке файла.</span>');
                }
            });
        }
    </script>
</body>
</html>