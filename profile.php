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
                        <a class="nav-link current" href="redirectToGame.php"><i class="fa fa-home"></i> комнаты</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Ссылки для авторизованных пользователей -->
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa fa-comments"></i> чат</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link current" href="profile.php"><i class="fa fa-user"></i> профиль</a>
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
            <div class="avatar"><img src="<?php echo htmlspecialchars($user['AvatarURL'] ?? 'default-avatar.png'); ?>" alt="Аватар"></div>
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
    </script>
</body>
</html>
