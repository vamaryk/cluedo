<?php
session_start();
// Если пользователь уже авторизован, перенаправляем его в личный кабинет
if (isset($_SESSION['user_id'])) {
    header('Location: profile.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cluedo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="gradient"></div>
    <!-- Меню -->
    <nav class="navbar navbar-expand-lg navbar-light rounded-[20px] p-3">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav gap-2">
                    <li class="nav-item">
                        <a class="nav-link current" href="#"><i class="fa fa-home"></i> комнаты</a>
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
                        <a class="nav-link" href="#"><i class="fa fa-book"></i> правила</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-cog"></i> настройки</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <h1>Cluedo</h1>
    <!-- Форма регистрации/авторизации -->
    <div class="form-container">
        <div class="tabs">
            <span class="tab active" id="register-tab">регистрация</span>
            <span class="tab" id="login-tab">авторизация</span>
        </div>
        <div id="register-form" style="display: block;">
            <form id="registrationForm">
                <div class="form-group">
                    <input type="text" class="form-control" id="username" placeholder="имя пользователя" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="email" placeholder="электронная почта" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" placeholder="пароль" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="confirm_password" placeholder="повторите пароль" required>
                </div>
                <button type="submit" class="btn-register">зарегистрироваться</button>
            </form>
        </div>
        <div id="login-form" style="display: none;">
            <form id="loginForm">
                <div class="form-group">
                    <input type="text" class="form-control" id="login_username" placeholder="имя пользователя" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="login_password" placeholder="пароль" required>
                </div>
                <button type="submit" class="btn-register">войти</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Переключение между регистрацией и авторизацией
        document.getElementById('register-tab').addEventListener('click', function () {
            document.getElementById('register-tab').classList.add('active');
            document.getElementById('login-tab').classList.remove('active');
            document.getElementById('register-form').style.display = 'block';
            document.getElementById('login-form').style.display = 'none';
        });

        document.getElementById('login-tab').addEventListener('click', function () {
            document.getElementById('login-tab').classList.add('active');
            document.getElementById('register-tab').classList.remove('active');
            document.getElementById('register-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
        });

        // AJAX для отправки формы регистрации
        document.getElementById('registrationForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirm_password = document.getElementById('confirm_password').value;

            if (password !== confirm_password) {
                alert('Пароли не совпадают');
                return;
            }

            $.ajax({
                url: 'register.php',
                method: 'POST',
                data: {
                    username: username,
                    email: email,
                    password: password
                },
                success: function (response) {
                    //alert(response);
                    if (response === 'Успешная регистрация') {
                        window.location.href = 'index.php'; // Перенаправление после успешной регистрации
                    }
                },
                error: function () {
                    alert('Ошибка при отправке данных');
                }
            });
        });

        // AJAX для отправки формы авторизации
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const username = document.getElementById('login_username').value;
            const password = document.getElementById('login_password').value;

            $.ajax({
                url: 'login.php',
                method: 'POST',
                data: {
                    username: username,
                    password: password
                },
                success: function (response) {
                    //alert(response);
                    if (response === 'Успешный вход') {
                        window.location.href = 'profile.php'; // Перенаправление после успешного входа
                    }
                },
                error: function () {
                    alert('Ошибка при отправке данных');
                }
            });
        });
    </script>
</body>
</html>