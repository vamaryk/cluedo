<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Прототип поля Cluedo</title>
    <style>
        body {
            background: #f5f5f5;
            font-family: sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px;
            position: relative;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(27, 27px);
            grid-template-rows: repeat(27, 27px);
            /* gap: 1px; */
            background-color: black;
            padding: 1px;
        }

        .cell {
            width: 27px;
            height: 27px;
            background: #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            /* border-radius: 6px; */
            box-sizing: border-box;
            border: 1px solid #000;
        }

        .empty {
            background: #3CB371;
            border: none;
        }

        .walkable {
            background: #F4A460;
        }

        .blocked {
            background: #C0C0C0;
        }

        .room {
            background: #C0C0C0;
            border: none;
        }

        .player {
            background: #444;
            color: #fff;
            /* border: 3px solid #5c4033; */
            font-weight: bold;
        }

        .cell.border-top {
            border-top: 3px solid #5c4033;
        }

        .cell.border-right {
            border-right: 3px solid #5c4033;
        }

        .cell.border-bottom {
            border-bottom: 3px solid #5c4033;
        }

        .cell.border-left {
            border-left: 3px solid #5c4033;
        }

        /* Кнопка предположения */
        #suggestButton {
            position: fixed;
            bottom: 18px;
            right: 230px;
            padding: 10px 10px;
            font-size: 18px;
            cursor: pointer;
            display: none;
            background-color: #27ae60;
            color: white;
            border: 2px solid #228B22;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, transform 0.3s;
        }

        /* При наведении на кнопку */
        #suggestButton:hover {
            background-color: #2ecc71;
            transform: scale(1.05);
        }

        /* Модальное окно */
        #modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            text-align: center;
            font-size: 18px;
            z-index: 1000;
        }

        #modal button {
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #modal button:hover {
            background-color: #2ecc71;
        }

        /* Кнопка тайного хода */
        #secretPathButton {
            margin-top: 0px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            display: none;
            background-color: #8e44ad;
            color: white;
            border: 2px solid #9b59b6;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, transform 0.3s;
        }

        /* При наведении на кнопку */
        #secretPathButton:hover {
            background-color: #9b59b6;
            transform: scale(1.05);
        }

        /* Кнопка "Начать игру" */
        #startButton,
        #endTurnButton {
            margin-top: 10px;
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 8px;
            border: none;
            transition: background-color 0.3s, transform 0.3s;
            text-align: center;
        }

        /* Стиль для кнопки "Начать игру" */
        #startButton {
            background-color: #27ae60;
            color: white;
        }

        #startButton:hover {
            background-color: #2ecc71;
            transform: scale(1.1);
        }

        /* Стиль для кнопки "Завершить ход" */
        #endTurnButton {
            margin-top: 10px;
            background-color: #f39c12;
            color: white;
            display: none;
        }

        #endTurnButton:hover {
            background-color: #e67e22;
            transform: scale(1.1);
        }

        /* Тень для кнопок */
        #startButton,
        #endTurnButton {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Отображение хода */
        #turnStatus {
            margin-top: 5px;
            font-size: 20px;
            font-weight: bold;
            color: #333;
            background-color: #f5f5f5;
            padding: 10px 20px;
            border-radius: 8px;
            border: 2px solid #ddd;
            display: inline-block;
            transition: background-color 0.3s, transform 0.3s;
        }

        /* Увеличение статуса при смене хода */
        #turnStatus {
            background-color: #f5f5f5;
            transform: scale(1.05);
        }

        #dice {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            z-index: 100;
            text-align: center;
            font-family: sans-serif;
        }

        #dice .dice-face {
            font-size: 32px;
            margin: 0 8px;
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            border: 2px solid #ccc;
            border-radius: 6px;
            background: #f9f9f9;
        }

        #dice .dice-sum {
            margin-top: 10px;
            font-weight: bold;
            font-size: 18px;
        }

        #dice-sum {
            margin-top: 1em;
        }

        #rollDiceButton {
            margin-top: 10px;
            padding: 8px 16px;
            font-size: 14px;
            background-color: rgb(39, 174, 96);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #rollDiceButton:hover {
            background-color: rgb(80, 103, 85);
        }

        #rollDiceButton:disabled {
            background-color: #999;
            cursor: not-allowed;
        }

        .cell.highlight {
            background-color: rgb(255, 213, 0);
            cursor: pointer;
        }

        #playerCards {
            position: fixed; 
            top: 20px;           
            left: 20px;          
            width: 300px;        
            padding: 15px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            z-index: 100;        
        }

        #cardsContainer {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;         
            margin-top: 10px;
        }

        .card-item {
            width: 120px;      
            height: 170px;     
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 14px;   
            padding: 5px;
        }

        .card-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px; /* Немного скруглим */
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            margin: 100px auto;
            width: 300px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }

        .modal-content select {
            width: 100%;
            margin-bottom: 10px;
            padding: 5px;
        }

        .modal-content button {
            padding: 10px 20px;
            margin-top: 10px;
            cursor: pointer;
        }

        /* Кнопка "Сделать обвинение" */
        .action-button {
            position: fixed;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            border: 2px solid #8B0000;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, transform 0.3s;
            text-align: center;
            z-index: 10;
        }

        .accuse-button {
            background-color: #CD5C5C;
            color: white;
            bottom: 18px;
            right: 10px;
        }

        .accuse-button:hover {
            background-color: #FF4500;
            transform: scale(1.05);
        }
        
        #cluedo-notebook {
            position: fixed;
            top: 20px;
            bottom: 80px;
            right: 0;
            width: 25vw;
            background: #3CB371;
            border-left: 1px solid #ccc;
            box-shadow: -3px 0 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            box-sizing: border-box;
            overflow: hidden;
        }

        /* Таблица занимает всю высоту контейнера */
        #cluedo-table {
            border-collapse: collapse;
            width: 100%;
            /* max-width: 900px; */
            height: 100%;
            table-layout: fixed;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            font-size: 12px;
        }

        #cluedo-table tr:not(:nth-child(2)):not(:nth-child(8)):not(:nth-child(14)) {
            background-color: #f0f0f0;
        }

        /* Ячейки */
        #cluedo-table td {
            border: 1px solid #999;
            /* background-color: #f0f0f0; */
            text-align: center;
            vertical-align: middle;
            padding: 2px 4px;
            cursor: pointer;
            position: relative;
            overflow-wrap: break-word;
            height: calc(100% / 24);   /* равномерное распределение высоты по 24 строкам */
        }

        /* Заголовочные ячейки */
        #cluedo-table td:first-child {
            cursor: default;
            font-weight: bold;
            background-color: #f0f0f0;
            text-align: left;
            padding-left: 6px;
        }

        #cluedo-table tr:first-child td {
            cursor: default;
            font-weight: bold;
            background-color: #f0f0f0;
        }

        /* Метки */
        .mark-cross::after {
            content: "\2716";
            color: red;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 16px;
        }

        .mark-check::after {
            content: "\2714";
            color: green;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 16px;
        }

        .strikethrough {
            /* text-decoration: line-through;
            color: gray; */
            opacity: 0.6;
        }

        /* Адаптивность: уменьшение шрифта и padding на маленьких экранах */
        @media (max-width: 1200px) {
            #cluedo-notebook {
                width: 30vw;
                top: 30px;
                bottom: 30px;
                padding: 8px;
            }
            #cluedo-table {
                font-size: 11px;
            }
        }

        @media (max-width: 768px) {
            #cluedo-notebook {
                width: 40vw;
                top: 20px;
                bottom: 20px;
                padding: 6px;
            }
            #cluedo-table {
                font-size: 10px;
            }
        }
    </style>
</head>

<body>
    <div id="board" class="grid"></div>

    <div id="cluedo-notebook">
        <table id="cluedo-table" border="1" cellspacing="0" cellpadding="5">
          <colgroup>
            <col style="width: 40%;" />
            <col style="width: 12%;" />
            <col style="width: 12%;" />
            <col style="width: 12%;" />
            <col style="width: 12%;" />
            <col style="width: 12%;" />
          </colgroup>
          <tbody>
            <tr>
              <td></td>
              <td>1</td><td>2</td><td>3</td><td>4</td><td>5</td>
            </tr>
            <tr>
              <td>Подозреваемые:</td>
              <td colspan="5"></td>
            </tr>
            <tr data-card-id="1"><td>Надира</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="3"><td>Орхан</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="5"><td>Шахризар</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="4"><td>Малхун</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="2"><td>Эмине</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><td>Орудия:</td><td colspan="5"></td></tr>
            <tr data-card-id="6"><td>Джамбия</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="7"><td>Наргиле</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="8"><td>Фирдоуси</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="9"><td>Газель</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="10"><td>Шелковый шнур</td><td></td><td></td><td></td><td></td><td></td></tr> 
            <tr><td>Место убийства:</td><td colspan="5"></td></tr>
            <tr data-card-id="11"><td>Покои</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="12"><td>Павильон</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="13"><td>Галерея</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="14"><td>Кухня</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="16"><td>Тахтабош</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="15"><td>Макад</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="17"><td>Сад</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="18"><td>Хамам</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="19"><td>Сокровищница</td><td></td><td></td><td></td><td></td><td></td></tr>
          </tbody>
        </table>
    </div>

    <p id="turnStatus">Ход: Шахризар (Игрок)</p>

    <button id="suggestButton" style="display: none;">Сделать предположение</button>

    <button id="secretPathButton" style="display: none;">Воспользоваться тайным ходом</button>

    <button id="accuseButton" class="action-button accuse-button">Сделать обвинение</button>

    <button id="startButton">Начать игру</button>

    <div id="dice">
        <div>
            <span class="dice-face" id="dice1">⚀</span>
            <span class="dice-face" id="dice2">⚁</span>
        </div>
        <div id="dice-sum">Сумма: <span id="diceSum">0</span></div>
        <button id="rollDiceButton" style="display: none;">Подбросить кубики</button>
    </div>

    <button id="endTurnButton" style="display: none;">Завершить ход</button>

    <div id="playerCards" style="display: none;">
        <h3>Ваши карты:</h3>
        <div id="cardsContainer"></div>
    </div>

    <!-- Модальное окно для старой логики -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <h2>Вы сделали предположение</h2>
            <button id="modalButton">Ок</button>
        </div>
    </div>

    <!-- Новое модальное окно для выбора карт -->
    <div id="suggestModal" class="modal">
        <div class="modal-content">
            <h2>Сделайте предположение</h2>
            <label for="characterSelect">Выберите персонажа:</label>
            <select id="characterSelect"></select>
            <label for="weaponSelect">Выберите оружие:</label>
            <select id="weaponSelect"></select>
            <label for="roomSelect">Выберите комнату:</label>
            <select id="roomSelect"></select>
            <button id="suggestModalButton">Ок</button>
        </div>
    </div>

    <!-- Новое модальное окно для выбора карт -->
    <div id="accuseModal" class="modal">
        <div class="modal-content">
            <h2>Сделать обвинение</h2>
            <label>Выберите персонажа:</label>
            <select id="accuseCharacterSelect"></select><br>
            <label>Выберите оружие:</label>
            <select id="accuseWeaponSelect"></select><br>
            <label>Выберите комнату:</label>
            <select id="accuseRoomSelect"></select><br>
            <button id="accuseModalButton">Ок</button>
        </div>
    </div>

    <script>
        // Карта (матрица) поля с несколькими типами клеток
        const matrix = [
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 2, 2, 2, 2, 2, 2, 0, 0, 0, 1, 2, 2, 2, 2, 2, 1, 0, 0, 0, 0, 2, 2, 2, 2, 2, 0],
            [0, 2, 2, 2, 2, 2, 2, 0, 1, 1, 1, 2, 2, 2, 2, 2, 1, 1, 1, 0, 0, 2, 2, 2, 2, 2, 0],
            [0, 2, 2, 2, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 2, 0],
            [0, 2, 2, 2, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 2, 0],
            [0, 2, 2, 2, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 1, 7, 2, 2, 2, 2, 2, 0],
            [0, 2, 2, 2, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 1, 2, 8, 2, 2, 2, 2, 0],
            [0, 0, 2, 3, 4, 2, 1, 1, 1, 2, 5, 2, 2, 2, 2, 2, 6, 2, 1, 1, 1, 1, 1, 1, 1, 1, 0],
            [0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0],
            [0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 0],
            [0, 2, 2, 9, 2, 2, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 1, 1, 1, 2, 2, 2, 2, 2, 2, 0],
            [0, 2, 2, 2, 2, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 2, 2, 0],
            [0, 2, 2, 2, 2, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 2, 2, 1, 1, 12, 2, 2, 2, 2, 2, 2, 0],
            [0, 2, 2, 2, 2, 2, 2, 10, 1, 1, 2, 2, 2, 2, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 2, 2, 0],
            [0, 2, 2, 2, 2, 2, 2, 11, 1, 1, 2, 2, 2, 2, 2, 2, 2, 1, 1, 1, 2, 2, 2, 2, 2, 2, 0],
            [0, 2, 2, 2, 2, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 2, 2, 1, 1, 1, 2, 2, 2, 2, 2, 2, 0],
            [0, 2, 2, 2, 2, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0],
            [0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 13, 14, 2, 2, 0, 0],
            [0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 0],
            [0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 19, 2, 2, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 0],
            [0, 2, 2, 1, 1, 1, 2, 2, 1, 1, 1, 2, 2, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 0],
            [0, 2, 2, 2, 17, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 2, 2, 1, 1, 2, 2, 15, 16, 2, 2, 0, 0],
            [0, 2, 2, 2, 2, 2, 2, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0],
            [0, 2, 2, 2, 2, 2, 18, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 1, 1, 2, 2, 2, 2, 1, 1, 1, 0],
            [0, 2, 2, 2, 2, 2, 2, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 1, 1, 2, 2, 2, 2, 2, 20, 2, 0],
            [0, 2, 2, 2, 2, 2, 2, 2, 1, 1, 0, 2, 2, 2, 2, 2, 0, 0, 0, 2, 2, 2, 2, 2, 2, 2, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        ];

        const cells = {
            1: { id: 1, type: "walkable" },
            2: { id: 2, type: "blocked" },
            3: { id: 3, type: "room", RoomName: 11 },
            4: { id: 4, type: "room", RoomName: 11 },
            5: { id: 5, type: "room", RoomName: 12 },
            6: { id: 6, type: "room", RoomName: 12 },
            7: { id: 7, type: "room", RoomName: 13 },
            8: { id: 8, type: "room", RoomName: 13 },
            9: { id: 9, type: "room", RoomName: 14 },
            10: { id: 10, type: "room", RoomName: 14 },
            11: { id: 11, type: "room", RoomName: 14 },
            12: { id: 12, type: "room", RoomName: 15 },
            13: { id: 13, type: "room", RoomName: 16 },
            14: { id: 14, type: "room", RoomName: 16 },
            15: { id: 15, type: "room", RoomName: 16 },
            16: { id: 16, type: "room", RoomName: 16 },
            17: { id: 17, type: "room", RoomName: 17 },
            18: { id: 18, type: "room", RoomName: 17 },
            19: { id: 19, type: "room", RoomName: 18 },
            20: { id: 20, type: "room", RoomName: 19 }
        };

        const secretPaths = {
            "1": { from: { x: 3, y: 7 }, to: { x: 24, y: 24 } },
            "2": { from: { x: 4, y: 7 }, to: { x: 24, y: 24 } },
            "3": { from: { x: 24, y: 24 }, to: { x: 4, y: 7 } },
            "4": { from: { x: 4, y: 21 }, to: { x: 20, y: 5 } },
            "5": { from: { x: 20, y: 5 }, to: { x: 4, y: 21 } },
            "6": { from: { x: 6, y: 23 }, to: { x: 21, y: 6 } },
            "7": { from: { x: 21, y: 6 }, to: { x: 6, y: 23 } },
        };

        // Стартовые координаты игроков и ботов
        let playerPos = JSON.parse(localStorage.getItem("playerPos")) || { x: 9, y: 25 };

        // Фиксированные фишки (ID) начальные позиции для ботов
        let bots = [
            { id: 1, name: "Надира", x: 10, y: 1, steps: 10 },
            { id: 2, name: "Эмине", x: 16, y: 1, steps: 10 },
            { id: 3, name: "Орхан", x: 25, y: 7, steps: 10 },
            { id: 4, name: "Малхун", x: 1, y: 17, steps: 10 }
        ];

        // Фишка (ID) игрока
        let playerChipID = 5;
        let playerID = playerChipID;

        // Ход игры: тот, кто сейчас ходит (игрок или бот)
        let currentPlayer = "player";

        // Индекс бота, чей ход сейчас
        let currentBot = 0;

        // Количество ходов каждого бота
        let botSteps = 10;

        // Флаг, чтобы заблокировать действия игрока во время хода бота
        let isBotMoving = false;

        // Флаг, чтобы заблокировать действия игрока до начала игры
        let isGameStarted = false;

        // Флаг проигрыша игрока 
        let playerEliminated = false;

        const board = document.getElementById("board");

        const suggestButton = document.getElementById("suggestButton");
        const secretPathButton = document.getElementById("secretPathButton");
        const startButton = document.getElementById("startButton");
        const endTurnButton = document.getElementById("endTurnButton");
        const modal = document.getElementById("modal");
        const modalButton = document.getElementById("modalButton");
        const playerCards = document.getElementById("playerCards");
        const accuseButton = document.getElementById("accuseButton");
        const suggestModal = document.getElementById("suggestModal");
        const suggestModalButton = document.getElementById("suggestModalButton");

        // Сохраняемые параметры
        function saveGameState() {
            const gameState = {
                isGameStarted,
                playerPos,
                bots: bots.map(bot => ({ id: bot.id, name: bot.name, x: bot.x, y: bot.y, steps: bot.steps })),
                playerCards: JSON.parse(localStorage.getItem("playerCards")) || []
            };
            localStorage.setItem("gameState", JSON.stringify(gameState));
        }

        // Функция для загрузки сохраненных параметров
        function restoreGameState() {
            const savedState = JSON.parse(localStorage.getItem("gameState"));
            if (!savedState) return;
            isGameStarted = savedState.isGameStarted;
            playerPos = savedState.playerPos;
            bots = savedState.bots;
            // Восстановление карт игрока
            const savedCards = savedState.playerCards;
            if (savedCards.length > 0) {
                displayPlayerCards(savedCards);
                playerCards.style.display = "inline-block";
            }
            if (isGameStarted) {
                startButton.style.display = "none";
                rollDiceButton.style.display = "inline-block";
                endTurnButton.style.display = "inline-block";
                accuseButton.style.display = "inline-block";
                showSuggestButton();
                showSecretPathButton();
                showAccuseButton();
                renderBoard();
            }
        }

        // Поиск, какие клетки (ID) относятся к указанной комнате
        function fetchRoomCellsByRoomName(roomName) {
            fetch(`getRoomCellsByRoomName.php?roomName=${roomName}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error("Ошибка при получении клеток комнаты:", data.error);
                    } else {
                        console.log(`Клетки комнаты с RoomName ${roomName}:`, data);
                    }
                })
                .catch(error => {
                    console.error("Ошибка при выполнении запроса:", error);
                });
        }

        // Поиск, к какой комнате относится указанная клетка по ее координатам
        function fetchRoomNameByCoordinates(x, y) {
            // Проверим, существуют ли такие координаты
            if (y >= 0 && y < matrix.length && x >= 0 && x < matrix[y].length) {
                const cellId = matrix[y][x];
                console.log(`Cell ID at (${x}, ${y}): ${cellId}`);
                // Передает cellId в fetchRoomName
                fetchRoomName(cellId);
            } else {
                console.warn(`Координаты (${x}, ${y}) выходят за пределы матрицы`);
            }
        }

        // Поиск, к какой комнате относится указанная клетка по ее ID
        function fetchRoomName(cellId) {
            fetch(`getRoomName.php?cellId=${cellId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.RoomName !== null) {
                        console.log(`Room Name for cell ${cellId}: ${data.RoomName}`);
                    } else {
                        console.log(`No room found for cell ${cellId}`);
                    }
                })
                .catch(error => console.error("Ошибка при запросе:", error));
        }

        // Поиск, какому игроку соответствует данная фишка по ее ID
        function fetchChipCharacter(id) {
            fetch(`getChipCharacter.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error("Ошибка при получении ChipCharacter:", data.error);
                    } else {
                        console.log(`ChipCharacter для фишки с ID ${id}:`, data.ChipCharacter);
                    }
                })
                .catch(error => {
                    console.error("Ошибка при выполнении запроса:", error);
                });
        }

        // Поиск, какие координаты у данной фишки по ее ID
        function fetchChipCoordinates(id) {
            fetch(`getChipCoordinates.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error("Ошибка при получении координат фишки:", data.error);
                    } else {
                        console.log(`Координаты фишки с ID ${id}:`, data);
                    }
                })
                .catch(error => {
                    console.error("Ошибка при выполнении запроса:", error);
                });
        }

        // Поиск, к какой комнате ведет данная клетка с секретным проходом по ее ID
        function fetchSecretPassage(id) {
            fetch(`getSecretPassage.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error("Ошибка при получении Secret Passage:", data.error);
                    } else {
                        console.log(`Destination для SecretPassageID ${id}:`, data.Destination);
                    }
                })
                .catch(error => {
                    console.error("Ошибка при выполнении запроса:", error);
                });
        }

        // Отображение кнопки для тайного хода
        function showSecretPathButton() {
            if (!isGameStarted || currentPlayer !== "player") {
                secretPathButton.style.display = "none";
                return;
            }
            const cellId = matrix[playerPos.y][playerPos.x];
            const cell = cells[cellId];
            // Проверка, связана ли текущая клетка с потайным ходом
            for (let path in secretPaths) {
                if (secretPaths[path].from.x === playerPos.x && secretPaths[path].from.y === playerPos.y) {
                    secretPathButton.style.display = "inline-block";
                    return;
                }
            }
            secretPathButton.style.display = "none"; // Если не нашли соответствующей клетки — скрыть кнопку
        }

        // Функция секретного прохода
        function useSecretPath() {
            // Проверка, связана ли текущая клетка с потайным ходом
            for (let path in secretPaths) {
                if (secretPaths[path].from.x === playerPos.x && secretPaths[path].from.y === playerPos.y) {
                    playerPos = { x: secretPaths[path].to.x, y: secretPaths[path].to.y };
                    savePlayerPos();  // Сохранение новой позиции
                    renderBoard();    // Отображение обновлённой карты
                    showSuggestButton();  // Проверка, нужно ли показывать кнопку для предположения
                    showSecretPathButton(); // Проверка, нужно ли показывать кнопку для тайного хода
                    setTimeout(() => {
                        currentPlayer = currentBot;
                        suggestButton.style.display = "none";
                        secretPathButton.style.display = "none";
                        endTurnButton.style.display = "none";
                        accuseButton.style.display = "none";
                        rollDiceButton.style.display = "none";
                        saveGameState();
                        botMove();
                    }, 5); // небольшая задержка, чтобы игрок успел увидеть перемещение
                    return;
                }
            }
        }

        // Обработчик для тайного хода
        secretPathButton.addEventListener("click", useSecretPath);

        // Функция для отображения кнопки предположения
        function showSuggestButton() {
            if (!isGameStarted || currentPlayer !== "player") {
                suggestButton.style.display = "none";
                return;
            }
            const cellId = matrix[playerPos.y][playerPos.x];
            const cell = cells[cellId];
            if (cell && cell.type === "room") {
                suggestButton.style.display = "inline-block";
            } else {
                suggestButton.style.display = "none";
            }
        }

        // Функция для загрузки карт из БД по типу
        async function loadCardsByType(type) {
            try {
                const response = await fetch('getCards.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ type: type })
                });
                const data = await response.json();
                return data.cards;
            } catch (error) {
                console.error('Ошибка загрузки карт:', error);
                return [];
            }
        }

        // Функция для создания выпадающего списка
        function createDropdown(cards, selectId) {
            const select = document.getElementById(selectId);
            select.innerHTML = ''; // Очистим текущие опции
            cards.forEach(card => {
                const option = document.createElement('option');
                option.value = card.ID;
                option.textContent = card.CardName;
                select.appendChild(option);
            });
        }

        // Обработчик для кнопки предположения
        suggestButton.addEventListener("click", async () => {
            suggestModal.style.display = "block"; // Открываем новое окно
            // Загрузка карт из БД
            const characters = await loadCardsByType('Character');
            const weapons = await loadCardsByType('Weapon');
            const rooms = await loadCardsByType('Room');
            // Заполнение выпадающих списков
            createDropdown(characters, 'characterSelect');
            createDropdown(weapons, 'weaponSelect');
            createDropdown(rooms, 'roomSelect');
        });

        // Обработчик для кнопки "Ок" в новом модальном окне
        suggestModalButton.addEventListener("click", async () => {
            const selectedCharacter = document.getElementById('characterSelect').value;
            const selectedWeapon = document.getElementById('weaponSelect').value;
            const selectedRoom = document.getElementById('roomSelect').value;
            if (selectedCharacter && selectedWeapon && selectedRoom) {
                const selectedCards = [selectedCharacter, selectedWeapon, selectedRoom];
                try {
                    // 1. Получаем ID карт
                    const responseIDs = await fetch('getCardIDs.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ cardNames: selectedCards })
                    });
                    const dataIDs = await responseIDs.json();
                    const cardIDs = dataIDs.cards.map(card => card.ID);
                    if (cardIDs.length !== 3) {
                        throw new Error("Не удалось получить все ID карт.");
                    }
                    // 2. Ищем игрока, у которого есть одна из карт
                    const responseCheck = await fetch('checkCards.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ cardIDs: cardIDs })
                    });
                    const dataCheck = await responseCheck.json();
                    const { playerID, cardName, noMatch } = dataCheck;
                    let message = "У других игроков нет таких карт.";
                    if (!noMatch && playerID) {
                        const bot = bots.find(b => b.id === parseInt(playerID));
                        if (bot) {
                            message = `У игрока ${bot.name} есть карта "${cardName}".`;
                        }
                    }
                    document.querySelector("#modal .modal-content h2").textContent = message;
                    // 3. Перемещение персонажа
                    const characterCardID = cardIDs[0]; // Первый элемент - это персонаж
                    const selectedCharacterCard = dataIDs.cards.find(card => card.ID === characterCardID);
                    if (selectedCharacterCard) {
                        const characterName = selectedCharacterCard.CardName;
                        // Находим бота по имени персонажа
                        const targetBot = bots.find(b => b.name === characterName);
                        if (targetBot) {
                            console.log(`Перемещаем персонажа ${characterName} (бота ${targetBot.name}) на позицию игрока.`);
                            // Перемещаем бота на клетку игрока
                            targetBot.x = playerPos.x;
                            targetBot.y = playerPos.y;
                            // Визуально обновляем позицию бота
                            const botElement = document.getElementById(`bot-${targetBot.id}`);
                            if (botElement) {
                                botElement.style.left = `${playerPos.x * cellSize}px`;
                                botElement.style.top = `${playerPos.y * cellSize}px`;
                            }
                        }
                    }
                } catch (error) {
                    console.error("Ошибка:", error);
                }
                suggestModal.style.display = "none";
                modal.style.display = "block";
                saveGameState();
            } else {
                alert("Пожалуйста, выберите все три карты.");
            }
        });

        // Завершить ход при нажатии на "Ок"
        modalButton.addEventListener("click", () => {
            // Проверяем, завершена ли игра (например, после правильного обвинения)
            if (!isGameStarted) {
                modal.style.display = "none";
                return;
            }

            if (currentPlayer === "player") {
                // Игрок завершил ход
                currentPlayer = currentBot; // Следующий ход - первый бот
                modal.style.display = "none";
                accuseButton.style.display = "none";
                suggestButton.style.display = "none";
                secretPathButton.style.display = "none";
                endTurnButton.style.display = "none";
                rollDiceButton.style.display = "none";

                // Если игрок был исключен - пропускаем его ход
                if (playerEliminated) {
                    currentPlayer = currentBot; // Сразу передаем ход боту
                }

                // Запуск хода следующего бота, если игра не завершена
                if (isGameStarted) {
                    botMove();
                }
            }
        });

        // Отображение кнопки "Сделать обвинение"
        function showAccuseButton() {
            if (!isGameStarted || currentPlayer !== "player") {
                accuseButton.style.display = "none";
                return;
            } else {
                accuseButton.style.display = "inline-block";
            }
        }

        // Обработчик клика на кнопку обвинения
        accuseButton.addEventListener("click", async () => {
            accuseModal.style.display = "block"; // Открываем новое окно
            // Загрузка карт из БД
            const characters = await loadCardsByType('Character');
            const weapons = await loadCardsByType('Weapon');
            const rooms = await loadCardsByType('Room');
            // Заполнение выпадающих списков
            createDropdown(characters, 'accuseCharacterSelect');
            createDropdown(weapons, 'accuseWeaponSelect');
            createDropdown(rooms, 'accuseRoomSelect');
        });

        // Функция сброса игры
        function resetGame() {
            // Сброс флагов
            isGameStarted = false;
            playerEliminated = false;
            currentPlayer = "player";
            isPlayerTurn = false;
            isDiceRolled = false;
            isBotMoving = false;

            // Скрытие всех кнопок управления
            rollDiceButton.style.display = "none";
            endTurnButton.style.display = "none";
            playerCards.style.display = "none";
            accuseButton.style.display = "none";
            suggestButton.style.display = "none";
            secretPathButton.style.display = "none";
            modal.style.display = "none";
            accuseModal.style.display = "none";

            // Отображение кнопки "Начать игру"
            startButton.style.display = "inline-block";

            // Сброс позиций игрока и ботов
            playerPos = { x: 9, y: 25 };
            savePlayerPos();
            bots = [
                { id: 1, name: "Надира", x: 10, y: 1, steps: 10 },
                { id: 2, name: "Эмине", x: 16, y: 1, steps: 10 },
                { id: 3, name: "Орхан", x: 25, y: 7, steps: 10 },
                { id: 4, name: "Малхун", x: 1, y: 17, steps: 10 }
            ];

            // Перерисовка игрового поля
            renderBoard();
            document.getElementById("turnStatus").innerText = "Игра окончена. Нажмите 'Начать игру' для новой игры.";
        }

        // Обработчик кнопки "Ок" в модальном окне выбора карт для обвинения
        accuseModalButton.addEventListener("click", async () => {
            const selectedCharacter = document.getElementById('accuseCharacterSelect').value;
            const selectedWeapon = document.getElementById('accuseWeaponSelect').value;
            const selectedRoom = document.getElementById('accuseRoomSelect').value;

            if (selectedCharacter && selectedWeapon && selectedRoom) {
                try {
                    const selectedCards = [selectedCharacter, selectedWeapon, selectedRoom];

                    const response = await fetch('checkAccusation.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ selectedCards })
                    });

                    const result = await response.json();

                    if (result.success) {
                        document.querySelector("#modal .modal-content h2").textContent = "Вы сделали верное обвинение!";
                        resetGame(); // Сброс игры
                    } else {
                        document.querySelector("#modal .modal-content h2").textContent = "Вы сделали неверное обвинение!";
                        playerEliminated = true;
                    }

                    accuseModal.style.display = "none";
                    modal.style.display = "block";

                    // Скрывает все кнопки, игрок больше не участвует в игре
                    accuseButton.style.display = "none";
                    suggestButton.style.display = "none";
                    endTurnButton.style.display = "none";
                    secretPathButton.style.display = "none";

                } catch (error) {
                    console.error("Ошибка при проверке обвинения:", error);
                }
            } else {
                alert("Пожалуйста, выберите все три карты.");
            }
        });

        // Проверка занятости клетки
        function isCellOccupied(x, y) {
            const cellId = matrix[y][x];
            const cell = cells[cellId];

            // Проверяем только клетки типа "walkable"
            if (cell && cell.type !== "walkable") return false;

            // Проверка, есть ли игрок на клетке
            if (playerPos.x === x && playerPos.y === y) return true;

            // Проверяем, есть ли бот на клетке
            for (let bot of bots) {
                if (bot.x === x && bot.y === y) return true;
            }

            return false; // Если клетка свободна
        }

        // Функция для случайного перемещения бота
        function randomMove(player) {
            const directions = [
                { x: 1, y: 0 }, // Вправо
                { x: -1, y: 0 }, // Влево
                { x: 0, y: 1 }, // Вниз
                { x: 0, y: -1 }  // Вверх
            ];
            const randomDirection = directions[Math.floor(Math.random() * directions.length)];
            let newX = player.x + randomDirection.x;
            let newY = player.y + randomDirection.y;
            // Проверка, чтобы не выйти за границы поля
            if (newX >= 0 && newY >= 0 && newX < matrix[0].length && newY < matrix.length) {
                const cellId = matrix[newY][newX];
                const cell = cells[cellId];
                // Проверка, что клетка walkable или room
                if ((cell && (cell.type === "walkable" || cell.type === "room")) && !isCellOccupied(newX, newY)) {
                    return { x: newX, y: newY };
                }
            }
            return player; // Если шаг не удается, бот остаётся на месте
        }

        // Функция для поэтапного перемещения бота
        function botMove() {
            if (isBotMoving) return; // Если бот уже в движении - не даст начать новый ход
            isBotMoving = true; // Флаг, что бот в движении
            let bot = bots[currentBot];
            let currentStep = 0;
            // Обновляет статус хода, показывая имя текущего бота
            document.getElementById("turnStatus").innerText = `Ход: ${bot.name}`;
            // Функция для анимации одного шага бота
            function moveStep() {
                if (currentStep < bot.steps) {
                    const newPos = pathfindingMove(bot);
                    if (newPos !== bot) { // Если перемещение удалось
                        bot.x = newPos.x;
                        bot.y = newPos.y;
                    }
                    renderBoard(); // Обновляет поле с каждым шагом
                    currentStep++;
                    // После шага делается задержка перед следующим шагом
                    setTimeout(moveStep, 250); // Задержка 500ms
                } else {
                    // Когда все шаги завершены, бот завершает ход и передает очередь следующему
                    isBotMoving = false; // Разрешается следующий ход
                    currentBot = (currentBot + 1) % bots.length;
            // Если текущий бот был последним и игрок еще не исключен
            if (currentBot === 0) {
                if (!playerEliminated) {
                    currentPlayer = "player"; 
                    endTurnButton.style.display = "inline-block";
                    document.getElementById("turnStatus").innerText = `Ход: Шахризар (Игрок)`;
                    renderBoard();
                    showSuggestButton();
                    showSecretPathButton();
                    showAccuseButton();
                    rollDiceButton.style.display = "inline-block";
                    rollDiceButton.disabled = false;
                    isDiceRolled = false;
                    isPlayerTurn = true;
                } else {
                    // Игрок исключен - сразу начинаем новый цикл ботов
                    botMove();
                    }
                } else {
                        botMove(); // Передаем ход следующему боту
                    }
                }
            }
            moveStep(); // Запуск первого шага
        }

        //Функция поиска пути в указанное место (новую комнату) для бота
        function findPathToNewRoom(startX, startY, visitedRooms) {
            const visited = new Set();
            const queue = [{ x: startX, y: startY, path: [] }];

            while (queue.length > 0) {
                const { x, y, path } = queue.shift();
                const key = `${x},${y}`;
                if (visited.has(key)) continue;
                visited.add(key);

                if (x >= 0 && y >= 0 && y < matrix.length && x < matrix[0].length) {
                    const cellId = matrix[y][x];
                    const cell = cells[cellId];

                    // Если найдена комната, которую бот еще не посещал
                    if (cell && cell.type === "room" && !visitedRooms.includes(cellId)) {
                        return path.concat({ x, y });
                    }

                    const directions = [
                        { x: 1, y: 0 },
                        { x: -1, y: 0 },
                        { x: 0, y: 1 },
                        { x: 0, y: -1 }
                    ];

                    for (const dir of directions) {
                        const newX = x + dir.x;
                        const newY = y + dir.y;
                        const newKey = `${newX},${newY}`;

                        if (
                            newX >= 0 &&
                            newY >= 0 &&
                            newX < matrix[0].length &&
                            newY < matrix.length &&
                            !visited.has(newKey)
                        ) {
                            const nextCellId = matrix[newY][newX];
                            const nextCell = cells[nextCellId];
                            if (
                                nextCell &&
                                (nextCell.type === "walkable" || nextCell.type === "room") &&
                                !isCellOccupied(newX, newY)
                            ) {
                                queue.push({
                                    x: newX,
                                    y: newY,
                                    path: path.concat({ x: newX, y: newY })
                                });
                            }
                        }
                    }
                }
            }
            return null; // Если все комнаты посещены
        }

        //Функция следования пути для бота
        function pathfindingMove(bot) {
            if (!bot.visitedRooms) bot.visitedRooms = [];

            if (!bot.path || bot.path.length === 0) {
                const currentCellId = matrix[bot.y][bot.x];
                const currentCell = cells[currentCellId];

                // Если бот в комнате, добавить её в список посещённых и выйти
                if (currentCell && currentCell.type === "room" && !bot.visitedRooms.includes(currentCellId)) {
                    bot.visitedRooms.push(currentCellId);

                    // Найти соседнюю "walkable" клетку для выхода
                    const directions = [
                        { x: 1, y: 0 },
                        { x: -1, y: 0 },
                        { x: 0, y: 1 },
                        { x: 0, y: -1 }
                    ];

                    for (const dir of directions) {
                        const exitX = bot.x + dir.x;
                        const exitY = bot.y + dir.y;
                        const exitCellId = matrix[exitY][exitX];
                        const exitCell = cells[exitCellId];

                        if (
                            exitX >= 0 &&
                            exitY >= 0 &&
                            exitX < matrix[0].length &&
                            exitY < matrix.length &&
                            exitCell &&
                            exitCell.type === "walkable" &&
                            !isCellOccupied(exitX, exitY)
                        ) {
                            bot.path = [{ x: exitX, y: exitY }];
                            return bot.path.shift();
                        }
                    }
                }

                // Ищет новую непосещённую комнату
                const path = findPathToNewRoom(bot.x, bot.y, bot.visitedRooms);
                if (path) {
                    bot.path = path;
                } else {
                    return { x: bot.x, y: bot.y }; // Остаться на месте, если все комнаты посещены
                }
            }

            const nextStep = bot.path.shift();
            if (!isCellOccupied(nextStep.x, nextStep.y)) {
                return nextStep;
            } else {
                bot.path = []; // Перестроить путь, если блокировано
                return { x: bot.x, y: bot.y };
            }
        }

        // Обработчик кнопки "Начать игру"
        startButton.addEventListener("click", async () => {
        localStorage.clear(); // Очистка данных предыдущей игры
        clearNotebook();
        playerCards.style.display = "none"; // Скрывает карты игрока
        startButton.style.display = "none";
        rollDiceButton.style.display = "inline-block";
        endTurnButton.style.display = "inline-block";
        playerCards.style.display = "inline-block";
        accuseButton.style.display = "inline-block";
        document.getElementById("turnStatus").innerText = `Ход: Шахризар (Игрок)`;
        currentPlayer = "player"; // Игрок начинает первый ход
        isGameStarted = true;
        try {
            // Отправка запроса на создание игры
            const response = await fetch("createGameSession.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    playerID: 5, // ID пользователя
                    bots: bots.map(bot => bot.id)
                })
            });
            if (!response.ok) throw new Error("Ошибка при создании игры");
            const data = await response.json();
            console.log("Игра создана:", data);
            await loadPlayerCards();
            // Отображение карт игрока
            displayPlayerCards(data.playerCards);
        } catch (error) {
            console.error("Ошибка:", error);
            alert("Не удалось создать игру");
        }
        renderBoard();
        showSuggestButton();
        showSecretPathButton();
        showAccuseButton();
        saveGameState();
        });

        // Обработчик кнопки "Завершить ход"
        endTurnButton.addEventListener("click", () => {
            if (currentPlayer === "player") {
                // Игрок завершил ход
                currentPlayer = currentBot; // Следующий ход - первый бот
                accuseButton.style.display = "none";
                modal.style.display = "none";
                suggestButton.style.display = "none";
                secretPathButton.style.display = "none";
                endTurnButton.style.display = "none";
                rollDiceButton.style.display = "none";
                saveGameState();
                botMove(); // Перемещает первого бота
            }
        });

        function displayPlayerCards(cards) {
            const container = document.getElementById("cardsContainer");
            container.innerHTML = "";
            cards.forEach(card => {
                const cardDiv = document.createElement("div");
                cardDiv.className = "card-item";
                cardDiv.innerHTML = `<img src="${card.image}" alt="${card.name}" width="60" height="60" style="margin-bottom: 5px;">`;
                container.appendChild(cardDiv);
            });
            // Сохранение карт игрока в localStorage
            localStorage.setItem("playerCards", JSON.stringify(cards));
            saveGameState(); // Обновляем сохранение
            // Отметка карт в бланке
            markPlayerCards(cards);
        }

        // Массив эмодзи для костей (Unicode символы ⚀-⚅)
        const diceSymbols = ['⚀', '⚁', '⚂', '⚃', '⚄', '⚅'];

        const dice1El = document.getElementById("dice1");
        const dice2El = document.getElementById("dice2");
        const diceSum_cont = document.getElementById("dice-sum");
        const diceSumEl = document.getElementById("diceSum");
        const rollDiceButton = document.getElementById("rollDiceButton");

        let diceSum = 0;
        let possibleMoves = [];
        let isDiceRolled = false; // Флаг, что кости подброшены
        let isPlayerTurn = false; // Флаг, что сейчас ход игрока
        let isMoveCompleted = false; // Флаг, что игрок завершил ход

        // Функция броска костей
        rollDiceButton.addEventListener("click", () => {
            if (isDiceRolled) return;
            const d1 = Math.floor(Math.random() * 6) + 1;
            const d2 = Math.floor(Math.random() * 6) + 1;

            dice1El.textContent = diceSymbols[d1 - 1];
            dice2El.textContent = diceSymbols[d2 - 1];

            diceSum = d1 + d2;
            diceSumEl.textContent = diceSum;
            diceSum_cont.style.display = "block";

            highlightPossibleMoves(diceSum);
            isDiceRolled = true;
            rollDiceButton.disabled = true;
        });

        // Функция поиска возможных ходов
        function getPossibleMoves(startX, startY, maxSteps) {
            const result = [];
            const visited = {};
            const queue = [];
            const currentCellId = matrix[startY][startX];
            const currentCell = cells[currentCellId];
            const roomCells = [];

            // Проверяем, находится ли игрок в комнате
            if (currentCell && currentCell.type === "room") {
                const roomName = currentCell.RoomName;

            // Находим все клетки этой комнаты
            for (let y = 0; y < matrix.length; y++) {
                for (let x = 0; x < matrix[y].length; x++) {
                    const cellId = matrix[y][x];
                    const cell = cells[cellId];
                    if (cell && cell.type === "room" && cell.RoomName === roomName) {
                        roomCells.push({ x, y });
                        }
                    }
                }
            }

            // Если игрок в комнате, добавляем все клетки комнаты в очередь
            if (roomCells.length > 0) {
                roomCells.forEach(cell => {
                    queue.push({ x: cell.x, y: cell.y, steps: 0 });
                });
            } else {
                // Если не в комнате, стартуем с текущей клетки
                queue.push({ x: startX, y: startY, steps: 0 });
            }
            while (queue.length > 0) {
                const { x, y, steps } = queue.shift();
                const key = `${x},${y}`;
                if (visited[key] || steps > maxSteps) continue;
                visited[key] = true;

                // Проверка клетки на доступность и отсутствие занятости
                if (steps <= maxSteps && !isCellOccupied(x, y)) {
                    result.push([x, y]);
                }
                if (steps === maxSteps) continue;

                // Четыре направления
                const directions = [
                    { dx: 0, dy: -1 },
                    { dx: 1, dy: 0 },
                    { dx: 0, dy: 1 },
                    { dx: -1, dy: 0 }
                ];
                directions.forEach(({ dx, dy }) => {
                    const nx = x + dx;
                    const ny = y + dy;
                    if (canMove(nx, ny) && !isCellOccupied(nx, ny)) {
                        const cellId = matrix[ny][nx];
                        const cell = cells[cellId];
                        if (cell && (cell.type === "walkable" || cell.type === "room")) {
                            queue.push({ x: nx, y: ny, steps: steps + 1 });
                        }
                    }
                });
            }
            return result;
        }

        // Подсветка возможных ходов
        function highlightPossibleMoves(steps) {
            document.querySelectorAll(".cell.highlight").forEach(cell => {
                cell.classList.remove("highlight");
                cell.removeEventListener("click", handleCellClick);
            });
            possibleMoves = getPossibleMoves(playerPos.x, playerPos.y, steps);
            possibleMoves.forEach(([x, y]) => {
                const cell = document.querySelector(`.cell[data-x="${x}"][data-y="${y}"]`);
                if (cell) {
                    cell.classList.add("highlight");
                    cell.addEventListener("click", handleCellClick);
                }
            });
        }

        // Обработка клика по клетке
        function handleCellClick(event) {
            const x = parseInt(event.currentTarget.getAttribute("data-x"));
            const y = parseInt(event.currentTarget.getAttribute("data-y"));
            if (possibleMoves.some(([px, py]) => px === x && py === y)) {
                playerPos = { x, y };
                savePlayerPos();
                renderBoard();

                // Сброс состояния
                document.querySelectorAll(".cell.highlight").forEach(cell => {
                    cell.classList.remove("highlight");
                    cell.removeEventListener("click", handleCellClick);
                });
                diceSum = 0;
                dice1El.textContent = '⚀';
                dice2El.textContent = '⚀';
                diceSum_cont.style.display = "none";
                isMoveCompleted = true; // Ход завершён

                // Проверка комнаты и кнопок
                const cellId = matrix[playerPos.y][playerPos.x];
                const cellType = cells[cellId]?.type;
                if (cellType === "room") {
                    showSuggestButton();
                } else {
                    if (currentPlayer === "player") {
                        // Игрок завершил ход
                        currentPlayer = currentBot; // Следующий ход - первый бот
                        endTurnButton.style.display = "none";
                        modal.style.display = "none";
                        suggestButton.style.display = "none";
                        secretPathButton.style.display = "none";
                        accuseButton.style.display = "none";
                        saveGameState();
                        botMove(); // Перемещает первого бота
            }
                }
                showSecretPathButton();
            }
        }

        // Отображение поля
        function renderBoard() {
            board.innerHTML = "";
            for (let y = 0; y < matrix.length; y++) {
                for (let x = 0; x < matrix[0].length; x++) {
                    const cellId = matrix[y][x];
                    const div = document.createElement("div");
                    div.classList.add("cell");
                    div.setAttribute("data-x", x);
                    div.setAttribute("data-y", y);

                    if (cellId === 0) {
                        div.classList.add("empty");
                    } else {
                        const cell = cells[cellId];
                        div.classList.add(cell.type);

                        // Границы для заблокированных клеток комнат (серых)
                        if (cell.type === "blocked") {
                            const neighbor = (dx, dy) => {
                                const nx = x + dx;
                                const ny = y + dy;
                                if (ny >= 0 && ny < matrix.length && nx >= 0 && nx < matrix[0].length) {
                                    const nid = matrix[ny][nx];
                                    return cells[nid]?.type || "empty";
                                }
                                return "empty";
                            };

                            if (neighbor(0, -1) !== "blocked") div.classList.add("border-top");
                            if (neighbor(1, 0) !== "blocked") div.classList.add("border-right");
                            if (neighbor(0, 1) !== "blocked") div.classList.add("border-bottom");
                            if (neighbor(-1, 0) !== "blocked") div.classList.add("border-left");

                            if (neighbor(0, -1) === "blocked") div.style.borderTop = "none";
                            if (neighbor(1, 0) === "blocked") div.style.borderRight = "none";
                            if (neighbor(0, 1) === "blocked") div.style.borderBottom = "none";
                            if (neighbor(-1, 0) === "blocked") div.style.borderLeft = "none";

                            if (neighbor(0, -1) === "room") div.style.borderTop = "none";
                            if (neighbor(1, 0) === "room") div.style.borderRight = "none";
                            if (neighbor(0, 1) === "room") div.style.borderBottom = "none";
                            if (neighbor(-1, 0) === "room") div.style.borderLeft = "none";
                        }

                        // Границы для клеток поля (желтых)
                        if (cell.type === "walkable") {
                            const neighbor = (dx, dy) => {
                                const nx = x + dx;
                                const ny = y + dy;
                                if (ny >= 0 && ny < matrix.length && nx >= 0 && nx < matrix[0].length) {
                                    const nid = matrix[ny][nx];
                                    return cells[nid]?.type || "empty";
                                }
                                return "empty";
                            };

                            if (neighbor(0, -1) == "empty") div.classList.add("border-top");
                            if (neighbor(1, 0) == "empty") div.classList.add("border-right");
                            if (neighbor(0, 1) == "empty") div.classList.add("border-bottom");
                            if (neighbor(-1, 0) == "empty") div.classList.add("border-left");
                        }
                    }

                    if (playerPos.x === x && playerPos.y === y) {
                        div.classList.add("player");
                        div.innerText = "👳🏾‍‍";
                    }

                    // Боты
                    for (let i = 0; i < bots.length; i++) {
                        if (bots[i].x === x && bots[i].y === y) {
                            div.classList.add("player");
                            div.innerText = "🐪";
                        }
                    }

                    board.appendChild(div);
                }
            }
        }

        // Проверка, можно ли двигаться в клетку
        function canMove(x, y) {
            return (
                y >= 0 &&
                y < matrix.length &&
                x >= 0 &&
                x < matrix[0].length &&
                matrix[y][x] !== 0 &&
                matrix[y][x] !== 2 // Запреть ходить на заблокированные клетки
            );
        }

        function savePlayerPos() {
            localStorage.setItem("playerPos", JSON.stringify(playerPos));
        }

        // Управление движением игрока
        document.addEventListener("keydown", (e) => {
            if (!isGameStarted || isMoveCompleted || isBotMoving) return;

            let { x, y } = playerPos;

            if (e.key === "ArrowUp" || e.key === "w") y--;
            if (e.key === "ArrowDown" || e.key === "s") y++;
            if (e.key === "ArrowLeft" || e.key === "a") x--;
            if (e.key === "ArrowRight" || e.key === "d") x++;

            if (canMove(x, y) && !isCellOccupied(x, y)) {
                playerPos = { x, y };
                savePlayerPos();
                renderBoard();
                showSuggestButton();
                showSecretPathButton();

                // Сброс возможных ходов
                document.querySelectorAll(".cell.highlight").forEach(cell => {
                    cell.classList.remove("highlight");
                    cell.removeEventListener("click", handleCellClick);
                });

                diceSum = 0;
                dice1El.textContent = '⚀';
                dice2El.textContent = '⚀';
                diceSum_cont.style.display = "none";
                rollDiceButton.disabled = true;
                isDiceRolled = false;
                isMoveCompleted = true;
            }
        });

        // Обработка клика по ячейке блокнота
        document.addEventListener('DOMContentLoaded', () => {
            const table = document.getElementById('cluedo-table');

            table.addEventListener('click', (event) => {
                const target = event.target;
                if (target.tagName !== 'TD') return;

                const cell = target;
                const row = cell.parentElement;
                const rowIndex = row.rowIndex;
                const cellIndex = cell.cellIndex;

                // Игнорирует служебные строки и первую колонку
                if (cellIndex === 0 || rowIndex === 7 || rowIndex === 13 || rowIndex === 0 || rowIndex === 1) return;

                // Цикл меток: нет -> крестик -> галочка -> нет
                if (cell.classList.contains('mark-cross')) {
                    cell.classList.remove('mark-cross');
                    cell.classList.add('mark-check');
                } else if (cell.classList.contains('mark-check')) {
                    cell.classList.remove('mark-check');
                } else {
                    cell.classList.add('mark-cross');
                }

                // Сохранение изменений
                saveNotebookState();
            });

            // Восстановление состояний при загрузке
            loadNotebookState();
        });

        function saveNotebookState() {
            const notebook = document.getElementById("cluedo-table");
            const rows = notebook.querySelectorAll("tr[data-card-id]");
            const notebookState = {};

            rows.forEach(row => {
                const cardId = row.getAttribute("data-card-id");
                const cells = row.querySelectorAll("td");

                notebookState[cardId] = [];

                cells.forEach((cell, index) => {
                    if (index === 0) return; // Пропускает первую колонку с названием

                    if (cell.classList.contains("mark-cross")) {
                        notebookState[cardId][index - 1] = "cross";
                    } else if (cell.classList.contains("mark-check")) {
                        notebookState[cardId][index - 1] = "check";
                    } else {
                        notebookState[cardId][index - 1] = "";
                    }
                });
            });

            localStorage.setItem("notebookState", JSON.stringify(notebookState));
        }

        function loadNotebookState() {
            const notebookState = JSON.parse(localStorage.getItem("notebookState")) || {};
            const notebook = document.getElementById("cluedo-table");
            const rows = notebook.querySelectorAll("tr[data-card-id]");

            rows.forEach(row => {
                const cardId = row.getAttribute("data-card-id");
                const cells = row.querySelectorAll("td");

                if (notebookState[cardId]) {
                    notebookState[cardId].forEach((mark, index) => {
                        const cell = cells[index + 1]; // +1, чтобы пропустить первую колонку
                        cell.classList.remove("mark-cross", "mark-check");

                        if (mark === "cross") {
                            cell.classList.add("mark-cross");
                        } else if (mark === "check") {
                            cell.classList.add("mark-check");
                        }
                    });
                }
            });
        }

        function clearNotebook() {
            const notebook = document.getElementById("cluedo-table");
            const rows = notebook.querySelectorAll("tr[data-card-id]");

            rows.forEach(row => {
                const cells = row.querySelectorAll("td");
                cells.forEach(cell => {
                    cell.classList.remove("mark-cross", "mark-check");
                });
            });

            // Очистка данных из localStorage
            localStorage.removeItem("notebookState");
        }

        async function loadPlayerCards() {
            try {
                const response = await fetch("getPlayerCards.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ playerID: 5 }) // ID игрока
                });

                if (!response.ok) throw new Error("Ошибка при получении карт игрока");

                const data = await response.json();
                if (data.success) {
                    displayPlayerCards(data.cards); // Отображаем карты на экране и отмечаем в бланке
                } else {
                    console.error("Ошибка получения карт:", data.message);
                }
            } catch (error) {
                console.error("Ошибка:", error);
            }
        }

        function markPlayerCards(playerCards) {
            playerCards.forEach(card => {
                // Находим строку с соответствующим data-card-id
                const row = document.querySelector(`tr[data-card-id="${card.id}"]`);
                if (row) {
                    const playerCell = row.querySelector('td:nth-child(6)'); // Ячейка с меткой игрока (последняя колонка)
                    if (playerCell) {
                        playerCell.classList.add('mark-check');
                        row.classList.add('strikethrough');
                    }
                }
            });
        }

        renderBoard();
        showAccuseButton();
        showSuggestButton();
        showSecretPathButton();
        restoreGameState();
    </script>
</body>

</html>