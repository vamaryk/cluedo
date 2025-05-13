<?php
session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Правила | Cluedo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Play", sans-serif;
        }

        body {
            font-weight: 400;
            font-style: normal;
            background-color: #f8f9fa;
        }

        .gradient {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(255, 166, 88, 0.9), rgba(189, 222, 143, 0.9));
            background-blend-mode: overlay;
            position: fixed;
            z-index: -1;
        }

        .navbar {
            background-color: #FFF890 !important;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 2em;
            position: sticky;
            top: 2em;
        }

        .nav-link {
            color: #333;
            font-size: 16px;
        }

        .nav-link:hover, .current {
            color: #252525  !important;
            text-decoration: underline;
            text-underline-offset: .25em;
        }

        .logout-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color: #b02a37;
        }

        h1 {
            font-size: 2em;
            margin: 1em 0;
            text-align: center;
            color: #ECF9DB;
            font-weight: bold;
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
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link current" href="#"><i class="fa fa-book"></i> правила</a>
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

<h1>Cluedo: Восточный заговор</h1>

<div class="container mt-4">

    <h3>Сюжет</h3>
    <p>Однажды вечером в роскошном дворце одного из влиятельных шейхов произошло покушение на жизнь правителя. Однако, по неизвестной причине, удар был нанесён по его близкому советнику — человеку, знавшему множество тайн и хранившему ключи от семейного сокровища. Преступник скрылся, оставив после себя лишь загадочные следы и подозрения. Теперь каждый гость, присутствовавший в тот вечер во дворце, может быть причастен к злодеянию...</p>
    <p>Цель игры — выяснить, кто совершил это ужасное преступление, каким оружием он воспользовался и где именно было совершено нападение.</p>

    <h3>Участники:</h3>
    <ul>
        <li><strong>Надира</strong> — калфа;</li>
        <li><strong>Орхан</strong> — архитектор галерей;</li>
        <li><strong>Шахризар</strong> — придворный каллиграф;</li>
        <li><strong>Малхун</strong> — баш-хасеки;</li>
        <li><strong>Эмине</strong> — парфюмерша гарема.</li>
    </ul>
    <div>
        <img src="img/Надира.png" alt="Надира" class="img-fluid rounded mb-2" width="150">
        <img src="img/Орхан.png" alt="Орхан" class="img-fluid rounded mb-2" width="150">
        <img src="img/Шахризар.png" alt="Шахризар" class="img-fluid rounded mb-2" width="150">
        <img src="img/Малхун.png" alt="Малхун" class="img-fluid rounded mb-2" width="150">
        <img src="img/Эмине.png" alt="Эмине" class="img-fluid rounded mb-2" width="150">
    </div>

    <h3>Орудия преступления:</h3>
    <ul>
        <li>кинжал Джамбия;</li>
        <li>наргиле — курительный прибор у восточных народов, сходный с кальяном;</li>
        <li>фирдоуси "Сердце льва";</li>
        <li>газель — бронзовая статуэтка;</li>
        <li>шёдковый шнур.</li>
    </ul>
    <div>
        <img src="img/Джамбия.png" alt="Джамбия" class="img-fluid rounded mb-2" width="150">
        <img src="img/Наргиле.png" alt="Наргиле" class="img-fluid rounded mb-2" width="150">
        <img src="img/Фирдоуси.png" alt="Фирдоуси" class="img-fluid rounded mb-2" width="150">
        <img src="img/Газель.png" alt="Газель" class="img-fluid rounded mb-2" width="150">
        <img src="img/Шнур.png" alt="Шнур" class="img-fluid rounded mb-2" width="150">
    </div>

    <h3>Локации:</h3>
    <ul>
        <li>покои;</li>
        <li>павильон;</li>
        <li>галерея;</li>
        <li>кухня;</li>
        <li>тахтабош;</li>
        <li>макад;</li>
        <li>сад;;</li>
        <li>хамам;</li>
        <li>сокровищница.</li>
    </ul>

    <h3>Цель игры</h3>
    <p>Каждый игрок получает несколько карт, которые остаются скрытыми от других. Игроки перемещаются по локациям, делают предположения и пытаются определить тройку: <strong>преступник + оружие + место преступления</strong>.</p>

    <h3>Как играть</h3>
    <ol>
        <li>Перемещайте фишку своего персонажа с учётом выпавшего количества очков на игральных костях.</li>
        <li>Делайте предположения, если Вы добрались до комнаты или уже находитесь в ней: "Предположим, это был Шахризар кинжалом Джамбия в саду".
        <br>Если у любого игрока есть одна из названных карт, он должен показать её.
        <br>Помните, что Вы должны находиться в той комнате, о которой делаете предположение. Подозреваемый персонаж перемещается в эту комнату.</li>
        <li>Делайте записи в бланке. Отмечайте свои предположения и раскрытые карты.</li>
        <li>Игрок, который первым правильно назовёт все три элемента преступления, побеждает.</li>
    </ol>

    <h3>Совет</h3>
    <p>Не спешите делать обвинение! Убедитесь, что у вас нет противоречивых данных. Неправильное обвинение может выбыть Вас из игры.</p>

    <h3>Покушение на шейха</h3>
    <p>Только Вы можете раскрыть истину. Кто же скрывается за этим убийством? Возможно, один из доверенных лиц шейха? Или гость из дальней страны?</p>
    <p>Выберите свою роль и начните расследование прямо сейчас!</p>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap @5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js "></script>
</body>
</html>