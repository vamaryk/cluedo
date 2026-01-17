<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Подключение к базе данных
include 'db.php';

// Получение списка комнат
$stmt = $pdo->query("
    SELECT 
        g.ID AS gameID,
        g.GameName,
        g.GamePlayersAmount,
        g.GameStatus,
        g.GamePrivacy,
        COUNT(gp.PlayerUser) AS currentPlayers
    FROM Games g
    LEFT JOIN GamePlayers gp ON g.ID = gp.GamePlayerID
    WHERE g.GameStatus = 'Waiting'
    GROUP BY g.ID
    ORDER BY g.ID DESC
");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Игровые комнаты | Cluedo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    
    <style>
        /* .room-card { border-left: 4px solid #6f42c1; }
        .private-badge { background-color: #dc3545; }
        .public-badge { background-color: #28a745; } */
    </style>
</head>

<body>
    <div class="gradient"></div>
    <!-- <audio id="background-music" src="./audio/background-music.mp3" loop></audio> -->

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

    <!-- Панель комнат -->
    <div class="rooms-panel">

        <!-- Фильтры -->
        <div class="filters-container">
            <input type="text" id="searchInput" class="search-input" placeholder="поиск...">
            <!-- <select id="privacyFilter" class="filter-select">
                <option value="">Любая приватность</option>
                <option value="Open">Публичные</option>
                <option value="Closed">Приватные</option>
            </select> -->
            <!-- <select id="playersFilter" class="filter-select">
                <option value="">Любое кол-во игроков</option>
                <option value="3">3+</option>
                <option value="4">4+</option>
                <option value="5">5</option>
            </select> -->
            <button class="create-room-btn" data-bs-toggle="modal" data-bs-target="#createRoomModal">
                <i class="fas fa-plus"></i> создать комнату
            </button>
        </div>

        <!-- Список комнат -->
        <div class="rooms-grid" id="roomsList">
            <?php foreach ($rooms as $room): ?>
                <div class="room-card"
                     data-privacy="<?= htmlspecialchars($room['GamePrivacy']) ?>"
                     data-players="<?= $room['currentPlayers'] ?>"
                     data-name="<?= htmlspecialchars(strtolower($room['GameName'])) ?>">
                    <div class="room-title"><?= htmlspecialchars($room['GameName']) ?></div>
                    <div class="room-stats">
                        <span class="stat-item">Кол-во игроков: <?= $room['currentPlayers'] ?>/<?= $room['GamePlayersAmount'] ?></span>
                        <span class="stat-item privacy-badge <?= $room['GamePrivacy'] === 'Open' ? 'public' : 'private' ?>">
                            <?= $room['GamePrivacy'] === 'Open' ? 'открытый' : 'закрытый' ?>
                        </span>
                    </div>
                    <button class="join-btn" data-id="<?= $room['gameID'] ?>" data-privacy="<?= $room['GamePrivacy'] ?>">
                        Присоединиться
                    </button>
                </div>
            <?php endforeach; ?>
            <?php if (empty($rooms)): ?>
                <div class="empty-message">
                    Нет активных комнат. Создайте свою!
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Модальное окно: Создать комнату -->
    <div class="modal fade" id="createRoomModal" tabindex="-1" role="dialog" aria-modal="true"> <!-- tabindex="-1" role="dialog" aria-modal="true" -->
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; padding: 20px; background: #fafafa; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title w-100 text-center" style="color: #2c3e50; font-weight: bold; font-size: 1.3em; letter-spacing: 1px;">создание комнаты</h5>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size: 1.5em; color: #999;"></button> -->
                </div>
                <div class="modal-body pt-3">
                    <form id="createRoomForm">

                        <!-- Название комнаты -->
                        <div class="mb-3">
                            <input type="text" name="gameName" class="form-control" placeholder="название" 
                                style="border: 1px solid #ddd; border-radius: 12px; padding: 10px; font-size: 14px; background: white;">
                        </div>

                        <!-- Доступ: открытый / закрытый -->
                        <div class="mb-3">
                            <label class="d-block mb-2" style="font-size: 14px; color: #2c3e50; font-weight: 500;">доступ</label>
                            <div class="d-flex gap-3 align-items-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="privacy" id="openAccess" value="Open" checked>
                                    <label class="form-check-label" for="openAccess" style="font-size: 14px; color: #666;">открытый</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="privacy" id="closedAccess" value="Closed">
                                    <label class="form-check-label" for="closedAccess" style="font-size: 14px; color: #666;">закрытый</label>
                                </div>
                            </div>
                        </div>

                        <!-- Код доступа (пароль) -->
                        <div class="mb-3 password-field d-none">
                            <input type="password" name="password" class="form-control" placeholder="код доступа" 
                                style="border: 1px solid #ddd; border-radius: 12px; padding: 10px; font-size: 14px; background: white;">
                        </div>

                        <!-- Количество игроков -->
                        <div class="mb-3">
                            <label class="d-block mb-2" style="font-size: 14px; color: #2c3e50; font-weight: 500;">кол-во игроков</label>
                            <div class="d-flex gap-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="players" id="players2" value="2" checked>
                                    <label class="form-check-label" for="players2" style="font-size: 14px; color: #666;">2</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="players" id="players3" value="3">
                                    <label class="form-check-label" for="players3" style="font-size: 14px; color: #666;">3</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="players" id="players4" value="4">
                                    <label class="form-check-label" for="players4" style="font-size: 14px; color: #666;">4</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="players" id="players5" value="5">
                                    <label class="form-check-label" for="players5" style="font-size: 14px; color: #666;">5</label>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-success w-100" id="submitCreateRoom" 
                            style="background-color: #aaffaa; color: #2c3e50; border: none; border-radius: 12px; padding: 12px; font-weight: bold; font-size: 16px; letter-spacing: 1px;">
                        создать
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно: Ввод пароля -->
    <div class="modal fade" id="passwordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Введите пароль</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="password" id="roomPassword" class="form-control" placeholder="Пароль от комнаты">
                    <div id="passwordError" class="text-danger mt-2" style="display:none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary" id="submitPassword">Войти</button>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>


    document.addEventListener('DOMContentLoaded', function() {

        // Показ/скрытие поля "код доступа"
        const privacyRadios = document.querySelectorAll('input[name="privacy"]');
        const passwordField = document.querySelector('.password-field');

        privacyRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                if (radio.value === 'Closed') {
                    passwordField.classList.remove('d-none');
                } else {
                    passwordField.classList.add('d-none');
                }
            });
        });

        // Создание комнаты
        document.getElementById('submitCreateRoom').addEventListener('click', async () => {
            const formData = new FormData(document.getElementById('createRoomForm'));
            const data = Object.fromEntries(formData);

            if (data.privacy === 'Closed' && !data.password) {
                alert('Укажите пароль для приватной комнаты');
                return;
            }

            try {
                const res = await fetch('createRoom.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        userID: <?= json_encode($_SESSION['user_id']) ?>,
                        gameName: data.gameName || null,
                        privacy: data.privacy,
                        password: data.password || null,
                        players: parseInt(data.players)
                    })
                });
                const result = await res.json();
                if (result.error) throw new Error(result.error);
                window.location.href = `lobby.php?gameID=${result.gameID}`;
            } catch (e) {
                alert('Ошибка: ' + e.message);
            }
        });

        // Присоединение к комнате
        let selectedRoomID = null;
        document.querySelectorAll('.join-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                selectedRoomID = btn.dataset.id;
                if (btn.dataset.privacy === 'Closed') {
                    // document.getElementById('passwordModal').style.display = 'block';
                    // const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('passwordModal'));
                    // modal.show();
                    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('passwordModal'));
                    modal.show();
                } else {
                    joinRoom(selectedRoomID, null);
                }
            });
        });

        document.getElementById('submitPassword').addEventListener('click', () => {
            const password = document.getElementById('roomPassword').value;
            joinRoom(selectedRoomID, password);
        });

        async function joinRoom(gameID, password = null) {
            try {
                const res = await fetch('joinRoom.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        gameID: gameID,
                        password: password
                    })
                });
                const result = await res.json();
                if (result.error) {
                    document.getElementById('passwordError').textContent = result.error;
                    document.getElementById('passwordError').style.display = 'block';
                    return;
                }
                window.location.href = `lobby.php?gameID=${gameID}`;
            } catch (e) {
                alert('Ошибка подключения: ' + e.message);
            }
        }

        // фильтр
        function filterRooms() {
            const searchInput = document.getElementById('searchInput');
            if (!searchInput) return;

            const search = searchInput.value.toLowerCase();
            // const privacy = document.getElementById('privacyFilter')?.value || '';
            // const minPlayers = parseInt(document.getElementById('playersFilter')?.value) || 0;

            document.querySelectorAll('#roomsList .room-card').forEach(card => {
                const name = card.dataset.name || '';
                // const roomPrivacy = card.dataset.privacy || '';
                // const players = parseInt(card.dataset.players) || 0;

                // const matches = name.includes(search) &&
                //             (!privacy || roomPrivacy === privacy) &&
                //             players >= minPlayers;

                card.style.display = name.includes(search) ? 'block' : 'none';
            });
        }

        // Безопасное добавление обработчика
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', filterRooms);
        }
        // document.getElementById('searchInput').addEventListener('input', filterRooms);
        // document.getElementById('privacyFilter').addEventListener('change', filterRooms);
        // document.getElementById('playersFilter').addEventListener('change', filterRooms);
    });
</script>
</body>
</html>