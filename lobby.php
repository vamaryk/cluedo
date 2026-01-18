<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
include 'db.php';

$gameID = (int)($_GET['gameID'] ?? 0);
if (!$gameID) {
    die("Не указан ID игры");
}

// Проверяем, состоит ли пользователь в этой игре
$stmt = $pdo->prepare("
    SELECT 1 FROM GamePlayers 
    WHERE GamePlayerID = ? AND PlayerUser = ?
");
$stmt->execute([$gameID, $_SESSION['user_id']]);
if (!$stmt->fetch()) {
    die("Вы не состоите в этой комнате");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лобби | Cluedo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.3.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        /* Стили лобби (уже есть в style.css, но дублируем для надёжности) */
        #roomName {
            color: #ffffff;
            font-size: 2rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .lobby-timer {
            font-size: 2.5rem;
            font-weight: bold;
            color: #ffffff;
            display: inline-block;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .lobby-players-grid {
            max-width: 600px;
            margin: 0 auto 2rem;
        }

        .lobby-player-slot {
            width: 100px;
            height: 100px;
            border: 2px solid #ffffff;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.2s;
            cursor: pointer;
            position: relative;
        }

        .lobby-player-slot:hover {
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.2);
        }

        .lobby-player-slot img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            margin-bottom: 5px;
        }

        .lobby-player-slot .username {
            font-size: 0.8rem;
            color: #ffffff;
            text-align: center;
            word-wrap: break-word;
            max-width: 100%;
        }

        .lobby-player-slot.empty {
            background: rgba(255, 255, 255, 0.05);
            border-style: dashed;
            border-color: #ffffff;
        }

        .lobby-player-slot.empty::before {
            content: '';
            width: 30px;
            height: 30px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            display: block;
            margin: 0 auto 10px;
        }

        .lobby-btn-success {
            background-color: #c8ffdb !important;
            color: #2c3e50 !important;
            font-weight: bold;
            font-size: 1.1rem;
            padding: 15px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border: none;
            width: 75%;
        }

        .lobby-btn-danger {
            background-color: #ff9999 !important;
            color: #2c3e50 !important;
            font-weight: bold;
            font-size: 1.1rem;
            padding: 15px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border: none;
            width: 75%;
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
                        <a class="nav-link current" href="lobby.php"><i class="fa fa-home"></i> комнаты</a>
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

    <div class="container py-4">
        <h2 id="roomName" class="text-center mb-4">Загадочный особняк</h2>

        <!-- Таймер (заглушка) -->
        <div class="text-center mb-4">
            <p>до начала:</p>
            <div class="lobby-timer">0:00</div>
        </div>

        <!-- Список игроков -->
        <div class="lobby-players-grid d-flex justify-content-center gap-3 mb-5"></div>

        <div class="d-flex flex-column align-items-center gap-3">
            <button id="startGameBtn" class="lobby-btn-success w-75 d-none">
                Начать игру
            </button>
            <button id="leaveBtn" class="lobby-btn-danger w-75">
                Выйти
            </button>
        </div>
    </div>

    <!-- Модальное окно подтверждения -->
    <div class="modal fade" id="leaveConfirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Подтверждение</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Вы хотите покинуть лобби? Комнаты без хоста будут удалены.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-danger" id="confirmLeaveBtn">Покинуть</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const gameID = <?= json_encode($gameID) ?>;
        const userID = <?= json_encode($_SESSION['user_id']) ?>;

        let isHost = false;

        // Загрузка данных лобби
        async function loadLobbyData() {
            try { 
                const res = await fetch(`getLobbyData.php?gameID=${gameID}`);
                const data = await res.json();

                if (data.deleted) {
                    alert('Хост покинул игру. Вы возвращаетесь в список комнат.');
                    window.location.href = 'rooms.php';
                    return;
                }

                if (data.error) {
                    console.warn('Ошибка загрузки лобби:', data.error);
                    return;
                }

                // Если игра уже запущена --- переходим в CluedoGameOnline.php
                if (data.game.GameStatus === 'InProgress') {
                    window.location.href = `online/CluedoGameOnline.php?gameID=${gameID}`;
                    return;
                }

                // Обновляем только если игра в Waiting
                document.getElementById('roomName').textContent = data.game.GameName;
                
                isHost = data.isHost;

                // Обновление списка игроков
                const playersGrid = document.querySelector('.lobby-players-grid');
                playersGrid.innerHTML = '';

                // Создание слотов игроков
                for (let i = 0; i < data.game.GamePlayersAmount; i++) {
                    const slot = document.createElement('div');
                    slot.className = 'lobby-player-slot';

                    if (i < data.players.length) {
                        const player = data.players[i];
                        slot.innerHTML = `
                            <img src="${player.AvatarURL || './img/default-avatar.png'}" alt="${player.UserName}">
                            <div class="username">${player.UserName}</div>
                        `;
                        if (player.ID == data.game.GameHost) {
                            slot.style.borderColor = '#aaffaa'; // выделение хоста
                        }
                    } else {
                        slot.classList.add('empty');
                        slot.innerHTML = '<div></div>';
                    }
                    playersGrid.appendChild(slot);
                }
                
                // Кнопка "Начать игру" видна только хосту
                document.getElementById('startGameBtn').classList.toggle('d-none', !isHost);
                
            } catch (e) {
                console.error(e);
            }
        }

        // Начать игру
        document.getElementById('startGameBtn').addEventListener('click', async () => {
            if (!confirm('Вы уверены, что хотите начать игру?')) return;
            try {
                const res = await fetch('./online/startGame.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ gameID })
                });
                const result = await res.json();
                if (result.error) {
                    alert('Ошибка: ' + result.error);
                } else {
                    window.location.href = `./online/CluedoGameOnline.php?gameID=${gameID}`;
                }
            } catch (e) {
                alert('Ошибка запуска: ' + e.message);
            }
        });

        // Открытие модального окна
        document.getElementById('leaveBtn').addEventListener('click', () => {
            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('leaveConfirmModal'));
            modal.show();
        });

        // Подтверждение выхода
        document.getElementById('confirmLeaveBtn').addEventListener('click', async () => {
            try {
                const res = await fetch('leaveRoom.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ gameID })
                });
                const result = await res.json();
                if (result.error) {
                    alert(result.error);
                } else {
                    // Перенаправляем на rooms.php
                    window.location.href = 'rooms.php';
                }
            } catch (e) {
                alert('Ошибка при выходе: ' + e.message);
            }
        });

        // Инициализация
        loadLobbyData();
        setInterval(loadLobbyData, 3000); // автообновление каждые 3 сек

    </script>
</body>
</html>