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
    <style>
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 1em;
            font-weight: 600;
            color: #dc3545;
        }
        .form-control.is-invalid ~ .invalid-feedback {
            display: block;
        }
        .form-control.is-invalid {
            border-color: #dc3545;
        }
    </style>
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
        </div>
    </nav>

    <h1>Cluedo</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']); // Удаляем сообщение об ошибке после отображения
    }
    ?>
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
                    <div class="invalid-feedback" id="username_error"></div>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="email" placeholder="электронная почта" required>
                    <div class="invalid-feedback" id="email_error"></div>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" placeholder="пароль" required>
                    <div class="invalid-feedback" id="password_error"></div>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="confirm_password" placeholder="повторите пароль" required>
                    <div class="invalid-feedback" id="confirm_password_error"></div>
                </div>
                <button type="submit" class="btn-register">зарегистрироваться</button>
            </form>
        </div>
        <div id="login-form" style="display: none;">
            <form id="loginForm">
                <div class="form-group">
                    <input type="text" class="form-control" id="login_username" placeholder="имя пользователя" required>
                    <!-- Элемент для отображения ошибки имени пользователя -->
                    <div class="invalid-feedback" id="login_username_error"></div>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="login_password" placeholder="пароль" required>
                    <!-- Элемент для отображения ошибки пароля -->
                    <div class="invalid-feedback" id="login_password_error"></div>
                </div>
                <button type="submit" class="btn-register">войти</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        
        // Вспомогательная функция для очистки ошибок авторизации
        function clearLoginErrors() {
            document.getElementById('login_username').classList.remove('is-invalid');
            document.getElementById('login_password').classList.remove('is-invalid');
            document.getElementById('login_username_error').textContent = '';
            document.getElementById('login_password_error').textContent = '';
        }

        // Вспомогательная функция для очистки ошибок регистрации
        function clearRegistrationErrors() {
            ['username', 'email', 'password', 'confirm_password'].forEach(id => {
                const inputElement = document.getElementById(id);
                const errorElement = document.getElementById(id + '_error');
                
                if (inputElement) inputElement.classList.remove('is-invalid');
                if (errorElement) errorElement.textContent = '';
            });
        }

        // Переключение между регистрацией и авторизацией
        document.getElementById('register-tab').addEventListener('click', function () {
            document.getElementById('register-tab').classList.add('active');
            document.getElementById('login-tab').classList.remove('active');
            document.getElementById('register-form').style.display = 'block';
            document.getElementById('login-form').style.display = 'none';
            clearLoginErrors(); 
        });

        document.getElementById('login-tab').addEventListener('click', function () {
            document.getElementById('login-tab').classList.add('active');
            document.getElementById('register-tab').classList.remove('active');
            document.getElementById('register-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
            clearRegistrationErrors(); // Очищаем ошибки регистрации при переключении
        });

        // AJAX для отправки формы регистрации
        document.getElementById('registrationForm').addEventListener('submit', function (e) {
            e.preventDefault();
            clearRegistrationErrors(); // Очищаем предыдущие ошибки

            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirm_password = document.getElementById('confirm_password').value;

            // Проверка совпадения паролей на клиенте
            if (password !== confirm_password) {
                document.getElementById('password').classList.add('is-invalid');
                document.getElementById('confirm_password').classList.add('is-invalid');
                document.getElementById('confirm_password_error').textContent = 'Пароли не совпадают';
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
                dataType: 'json', // Ожидаем JSON ответ
                success: function (response) {
                    if (response.success) {
                        window.location.href = 'profile.php'; // Перенаправление после успешной регистрации
                    } else {
                        // Обработка ошибки
                        if (response.field && response.field !== 'general') {
                            const fieldId = response.field;
                            const errorElement = document.getElementById(fieldId);
                            const errorFeedbackElement = document.getElementById(fieldId + '_error');
                            
                            if (errorElement && errorFeedbackElement) {
                                errorElement.classList.add('is-invalid');
                                errorFeedbackElement.textContent = response.message;
                            } else {
                                alert(response.message);
                            }
                        } else {
                            // Общая ошибка (например, ошибка базы данных)
                            alert('Ошибка регистрации: ' + response.message);
                        }
                    }
                },
                error: function () {
                    alert('Ошибка при отправке данных на сервер.');
                }
            });
        });

        // AJAX для отправки формы авторизации
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            e.preventDefault();
            clearLoginErrors(); // Очищаем предыдущие ошибки

            const username = document.getElementById('login_username').value;
            const password = document.getElementById('login_password').value;

            $.ajax({
                url: 'login.php',
                method: 'POST',
                data: {
                    username: username,
                    password: password
                },
                dataType: 'json', // Ожидаем JSON ответ
                success: function (response) {
                    if (response.success) {
                        window.location.href = 'profile.php'; // Перенаправление после успешного входа
                    } else {
                        // Обработка ошибки
                        if (response.error_type === 'credentials') {
                            // При ошибке учетных данных (неверный логин/пароль)
                            
                            // 1. Отображаем сообщение под полем пароля (или имени пользователя, как удобнее)
                            document.getElementById('login_password_error').textContent = response.message;
                            
                            // 2. Применяем класс is-invalid к обоим полям для визуального выделения
                            document.getElementById('login_username').classList.add('is-invalid');
                            document.getElementById('login_password').classList.add('is-invalid');

                        } else {
                            // Общая ошибка
                            alert(response.message);
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Ошибка сети или сервера
                    alert('Ошибка при отправке данных. Попробуйте позже.');
                }
            });
        });
    </script>
</body>
</html>