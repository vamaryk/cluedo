<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Cluedo</title>
    <style>
        body {
            background: #f5f5f5;
            font-family: sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px;
            position: relative;
            background-image: url('./img/Background.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
        }

        h3 {
            display: block;
            font-size: 1.17em;
            margin-block-start: 0;
            margin-block-end: 10px;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            font-weight: bold;
            unicode-bidi: isolate;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(27, 27px);
            grid-template-rows: repeat(27, 27px);
        
            background: 
                linear-gradient(180deg, rgba(255,255,255,0.05), rgba(0,0,0,0.15)),
                url('./img/map-texture.jpg'); /* позже подложишь */
            background-size: cover;
        
            padding: 12px;
            border-radius: 18px;
        
            box-shadow:
                0 20px 40px rgba(0,0,0,0.45),
                inset 0 0 0 3px rgba(255, 215, 160, 0.4);
        
            position: relative;
        }
        
        .cell {
            width: 27px;
            height: 27px;
            background: rgba(255, 248, 220, 0.85);
            border: none;
        
            box-shadow:
                inset 0 0 0 1px rgba(120, 90, 60, 0.25),
                inset 0 -1px 2px rgba(0,0,0,0.2);
        
            box-sizing: border-box;
        }
        
        .empty {
            background: transparent;
        }
        
        .walkable {
            background: rgba(240, 220, 180, 0.9);
        }

        .room,
        .blocked {
            background: rgba(180, 180, 180, 0.9);
            box-shadow:
                inset 0 0 0 2px rgba(90,90,90,0.4);
        }
        
        .player {
            position: relative; 
        }
        
        .player::after {
            content: attr(data-token);
            position: absolute;
            width: 90%;
            height: 90%;
            background: linear-gradient(145deg, #d6b26a, #a67c3a); 
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2b1c08;
            
            box-shadow: 
                0 0 15px rgba(255, 215, 0, 0.8),
                0 2px 5px rgba(0,0,0,0.5), 
                inset 0 1px 1px rgba(255,255,255,0.3);
                
            border: 2px solid #5c4033;
            z-index: 1;
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

        button,
        .action-button {
            font-family: inherit;
            background:
                linear-gradient(180deg, #d6b26a, #a67c3a);
        
            color: #2b1c08;
            border: 2px solid #5c4033;
        
            border-radius: 999px;
            padding: 10px 18px;
        
            box-shadow:
                0 6px 12px rgba(0,0,0,0.4),
                inset 0 2px 3px rgba(255,255,255,0.4);
        
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        
        button:hover {
            transform: translateY(-1px);
            box-shadow:
                0 8px 16px rgba(0,0,0,0.5),
                inset 0 2px 3px rgba(255,255,255,0.4);
        }
        
        #suggestButton {
            position: fixed;
            bottom: 20px;
            right: 230px;
            padding: 10px 18px; 
            font-size: 16px;  
            display: none;
        }
        
        #suggestButton:hover {
            transform: scale(1.05);
            transition: transform 0.2s ease, background-color 0.2s ease;
        }
        
        #suggestButton {
            border-radius: 8px; 
            padding: 10px 18px; 
            font-size: 16px; 
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
            /* padding: 10px 20px; */
            font-size: 16px;
            display: none;
        }
        
        /* Кнопка "Начать игру" и "Завершить ход" */
        #startButton,
        #endTurnButton {
            margin-top: 10px;
            padding: 15px 30px; 
            font-size: 18px;
            border-radius: 8px;
            border: none;
        }
        
        #endTurnButton {
            display: none;
        }
        
        /* Отображение хода */
        #turnStatus {
            margin-top: 12px;
        
            font-size: 16px;
            font-weight: bold;
        
            background:
                linear-gradient(180deg, rgba(245,235,210,0.95), rgba(220,200,160,0.95)),
                url('./img/paper-texture.jpg');
            background-size: cover;
            padding: 6px 12px;
        
            border-radius: 8px;
            border: 1px solid rgba(120,90,50,0.4);
        
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.5);
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

            background:
                linear-gradient(180deg, rgba(245,235,210,0.95), rgba(220,200,160,0.95)),
                url('./img/paper-texture.jpg');
            background-size: cover;

            padding: 16px 20px;
            border-radius: 16px;

            box-shadow:
                0 16px 30px rgba(0,0,0,0.45),
                inset 0 0 0 2px rgba(140,110,70,0.4);

            color: #2f2a20;
            text-align: center;
        }

        #dice .dice-face {
            font-size: 34px;
            width: 44px;
            height: 44px;
            line-height: 44px;
        
            background: #fffaf0;
            border-radius: 8px;
        
            border: 2px solid rgba(120,90,50,0.6);
            box-shadow:
                inset 0 -2px 3px rgba(0,0,0,0.25),
                0 3px 6px rgba(0,0,0,0.35);
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
            font-size: 14px;
        }
        
        button:disabled,
        .action-button:disabled {
            background: #ccc;
            border-color: #999;
            color: #666;
            box-shadow: none;
            cursor: not-allowed;
            transform: none;
            filter: grayscale(1);
        }

        .cell.highlight {
            cursor: pointer;
    
            background: #CFAA41;
    
            box-shadow: 
                0 0 10px 4px rgba(255, 215, 0, 0.9),
                inset 0 0 5px rgba(255, 255, 255, 0.5);
    
            animation: pulse 1s infinite alternate;
        }

        
        @keyframes pulse {
            from {
                box-shadow: 0 0 10px 4px rgba(255, 215, 0, 0.9), inset 0 0 5px rgba(255, 255, 255, 0.5);
            }
            to {
                box-shadow: 0 0 20px 6px rgba(255, 215, 0, 1), inset 0 0 8px rgba(255, 255, 255, 0.7);
            }
        }

        #playerCards {
            position: fixed;
            top: 20px;
            left: 20px;
        
            width: 180px;
            padding: 14px;
        
            background:
                linear-gradient(180deg, rgba(90,60,30,0.85), rgba(50,30,15,0.95)),
                url('./img/wood-texture.jpg');
            background-size: cover;
        
            border-radius: 14px;
        
            box-shadow:
                0 18px 35px rgba(0,0,0,0.5),
                inset 0 0 0 2px rgba(255,220,160,0.25);
        
            color: #f3e6c8;
            text-align: center;
        }

        #cardsContainer {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
        }

        .card-item {
            width: 115px;
            height: 160px;
        
            background: #fff;
            background: transparent;
            border-radius: 10px;

            box-shadow:
                0 6px 14px rgba(0,0,0,0.45);

            transform: rotate(var(--r, 0deg));
            transition: transform 0.2s ease;
        }

        .card-item:nth-child(odd) { --r: -3deg; }
        .card-item:nth-child(even) { --r: 3deg; }

        .card-item:hover {
            transform: scale(1.05) rotate(0deg);
            z-index: 2;
        }

        .card-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
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
            bottom: 18px;
            right: 10px;
        
            background: linear-gradient(180deg, #a33, #611);
            color: #fff;
            border-color: #3b0000;
            
            transition: transform 0.2s ease, background-color 0.2s ease;
        }
        
        .accuse-button:hover {
            background-color: #FF4500;
            transform: scale(1.05);
        }

        #endGameButton {
            font-family: inherit;
            font-size: 18px;
            padding: 10px 20px;
            text-align: center;
            z-index: 10;

            background: linear-gradient(180deg, #a33, #611);
    
            color: white;
    
            border: 2px solid #5c1a1a;
    
            border-radius: 999px;

            box-shadow:
                0 6px 12px rgba(0,0,0,0.4),
                inset 0 2px 3px rgba(255,255,255,0.3);
        
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        #endGameButton:hover {
            transform: translateY(-1px);
            
            background-color: #FF4500;
            
            box-shadow:
                0 8px 16px rgba(0,0,0,0.5),
                inset 0 2px 3px rgba(255,255,255,0.4);
        }
        
        #endGameButton:active {
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.4);
        }

        #notifications {
            position: fixed;
            right: 20px;
            bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 9999;
        }

        .notification {
            background: rgba(30, 30, 30, 0.95);
            color: #fff;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            min-width: 220px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.4);
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }

        .notification.show {
            opacity: 1;
            transform: translateY(0);
        }

        .notification.info { border-left: 4px solid #4da3ff; }
        .notification.success { border-left: 4px solid #5fd35f; }
        .notification.warn { border-left: 4px solid #ffb84d; }
      
        #cluedo-notebook {
            position: fixed;
            top: 20px;
            bottom: 80px;
            right: 0px;
        
            width: clamp(280px, 28vw, 580px);
        
            background:
                linear-gradient(180deg, rgba(255,255,255,0.85), rgba(235,225,200,0.9)),
                url('./img/paper-texture.jpg');
            background-size: cover;
        
            border-radius: 16px;
        
            box-shadow:
                0 25px 45px rgba(0,0,0,0.45),
                inset 0 0 0 2px rgba(140,110,70,0.4);
        
            padding: 14px 12px;
            box-sizing: border-box;
        
            overflow-y: auto;
        }

        #cluedo-table {
            border-collapse: collapse;
            width: 100%;
            height: 100%;

            font-size: 13px;
            color: #2f2a20;
        
            user-select: none;
        }
        
        #cluedo-table td:first-child,
        #cluedo-table tr:first-child td {
            background: rgba(220,200,160,0.6);
            font-weight: bold;
            text-align: left;
            padding-left: 6px;
            cursor: default;
        }
        
        /* Ячейки */
        #cluedo-table td {
            border: 1px solid rgba(120,90,50,0.35);
            background: rgba(255,255,255,0.6);
        
            text-align: center;
            vertical-align: middle;
            padding: 3px 4px;
        
            cursor: pointer;
            position: relative;
        
            transition: background 0.15s ease;
        }

        #cluedo-table tr:nth-child(even) td {
            background: rgba(250,245,235,0.8);
        }

        .mark-cross::after,
        .mark-check::after,
        .mark-question::after {
            content: "✕";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            
            font-weight: bold;
            font-size: 16px; 
        }
        
        .mark-cross::after {
            content: "✕";
            color: #7a1e1e;
        }
        
        .mark-check::after {
            content: "✓";
            color: #1f5f2e;
        }
        
        .mark-question::after {
            content: "?";
            color: #3a4a7a;
        }

        #cluedo-table td:hover {
            background: rgba(255,240,200,0.9);
        }

        .strikethrough {
            text-decoration: line-through;
            color: gray;
            opacity: 0.6;
        }

        /* Адаптивность */
        @media (max-width: 1366px) {
            .grid {
                grid-template-columns: repeat(27, 24px);
                grid-template-rows: repeat(27, 24px);
            }
            .cell {
                width: 24px;
                height: 24px;
                font-size: 16px;
            }
        }

        @media (max-width: 1024px) {
            body {
                flex-direction: row;
                align-items: flex-start;
            }

            #cluedo-notebook {
                position: fixed;
                right: 0;
                top: 0;
                bottom: 0;
                width: 320px;
                z-index: 200;
            }

            #dice {
                left: 10px;
                bottom: 10px;
                transform: scale(0.9);
            }

            #suggestButton,
            #accuseButton {
                transform: scale(0.9);
            }
        }
    </style>
</head>

<body>
    <div id="board" class="grid"></div>

    <div id="cluedo-notebook">
        <table id="cluedo-table" border="1" cellspacing="0" cellpadding="5">
          <colgroup>
            <col style="width: 38%;" />
            <col style="width: 15%;" />
            <col style="width: 15%;" />
            <col style="width: 15%;" />
            <col style="width: 15%;" />
            <col style="width: 18%;" />
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
            <tr data-card-id="2"><td>Эмине</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="3"><td>Орхан</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="4"><td>Малхун</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="5"><td>Шахризар</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><td>Орудия:</td><td colspan="5"></td></tr>
            <tr data-card-id="6"><td>Кинжал Джамбия</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="7"><td>Наргиле</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="8"><td>Фирдоуси</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="9"><td>Газель</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="10"><td>Шёлковый шнур</td><td></td><td></td><td></td><td></td><td></td></tr> 
            <tr><td>Место убийства:</td><td colspan="5"></td></tr>
            <tr data-card-id="11"><td>Покои</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="12"><td>Галерея</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="13"><td>Павильон</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="14"><td>Кухня</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="15"><td>Макад</td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr data-card-id="16"><td>Тахтабош</td><td></td><td></td><td></td><td></td><td></td></tr>
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

    <button id="endGameButton" style="display:none;">Завершить игру</button>

    <div id="dice">
        <div>
            <span class="dice-face" id="dice1">⚀</span>
            <span class="dice-face" id="dice2">⚁</span>
        </div>
        <div id="dice-sum">Сумма: <span id="diceSum">0</span></div>
        <button id="rollDiceButton" style="display: none;">Подбросить кубики</button>
    </div>

    <button id="endTurnButton" style="display: none;">Завершить ход</button>
    
    <div id="notifications"></div>

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

       const roomIdToName = {
           11: "Покои",
           12: "Галерея",
           13: "Павильон",
           14: "Кухня",
           15: "Макад",
           16: "Тахтабош",
           17: "Сад",
           18: "Хамам",
           19: "Сокровищница"
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
            { id: 1, name: "Надира", x: 10, y: 1, token: "", steps: 0, visitedRooms: [], knownCards: [], turnsPlayed: 0, eliminated: false, pendingSecret: false },
            { id: 2, name: "Эмине", x: 16, y: 1, token: "", steps: 0, visitedRooms: [], knownCards: [], turnsPlayed: 0, eliminated: false, pendingSecret: false },
            { id: 3, name: "Орхан", x: 25, y: 7, token: "", steps: 0, visitedRooms: [], knownCards: [], turnsPlayed: 0, eliminated: false, pendingSecret: false },
            { id: 4, name: "Малхун", x: 1, y: 17, token: "", steps: 0, visitedRooms: [], knownCards: [], turnsPlayed: 0, eliminated: false, pendingSecret: false }
        ];

        const playersInfo = [
            { id: 1, label: "Игрок 1: Надира", icon: "نادره" },
            { id: 2, label: "Игрок 2: Эмине", icon: "آمنه" },
            { id: 3, label: "Игрок 3: Орхан", icon: "اورخان" },
            { id: 4, label: "Игрок 4: Малхун", icon: "مالحون" },
            { id: 5, label: "Игрок 5: Шахризар", icon: "شهريزار‍" }
        ];

        function initNotebookHeader() {
            const headerRow = document.querySelector("#cluedo-table tr:first-child");
            const cells = headerRow.querySelectorAll("td");
            playersInfo.forEach((player, index) => {
                cells[index + 1].textContent = player.label;
            });
        }

        // Флаг активной игры
        let gameActive = true;

        // Фишка (ID) игрока
        const playerID = 5;

        // Ход игры: тот, кто сейчас ходит (игрок или бот)
        let currentPlayer = "player";

        // Индекс бота, чей ход сейчас
        let currentBot = 0;

        // Флаг, чтобы заблокировать действия игрока во время хода бота
        let isBotMoving = false;

        // Флаг, чтобы заблокировать действия игрока до начала игры
        let isGameStarted = false;

        // Флаг проигрыша игрока 
        let playerEliminated = false;

        const GamePhase = {
            INIT: "init",
            PLAYER_TURN: "player_turn",
            BOT_TURN: "bot_turn",
            PLAYER_ELIMINATED: "player_eliminated",
            GAME_OVER: "game_over"
        };

        let gamePhase = GamePhase.INIT;

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
        const endGameButton = document.getElementById("endGameButton");

        // Сохраняемые параметры
        function saveGameState() {
            const gameState = {
                isGameStarted,
                playerPos,
                bots: bots.map(bot => ({
                    id: bot.id,
                    name: bot.name,
                    x: bot.x,
                    y: bot.y,
                    steps: bot.steps,
                    visitedRooms: bot.visitedRooms,
                    knownCards: bot.knownCards,
                    turnsPlayed: bot.turnsPlayed,
                    eliminated: bot.eliminated
                })),
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
            if (isGameStarted && gamePhase !== GamePhase.GAME_OVER) {
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

        // Отображение кнопки для тайного хода
        function showSecretPathButton() {
            if (
                !isGameStarted ||
                currentPlayer !== "player" ||
                isDiceDone // 🔥 ВАЖНО
            ) {
                secretPathButton.style.display = "none";
                return;
            }
        
            const cellId = matrix[playerPos.y][playerPos.x];
            for (let path in secretPaths) {
                if (
                    secretPaths[path].from.x === playerPos.x &&
                    secretPaths[path].from.y === playerPos.y
                ) {
                    secretPathButton.style.display = "inline-block";
                    return;
                }
            }

            secretPathButton.style.display = "none";
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
                        resetDiceState();
                        rollDiceButton.style.display = "none";
                        rollDiceButton.disabled = true;
                        secretPathButton.style.display = "none";
                        showSuggestButton();
                        endTurnButton.style.display = "inline-block";
                        accuseButton.style.display = "inline-block";
                        gamePhase = GamePhase.PLAYER_TURN;
                        currentPlayer = "player";
                        saveGameState();
                    }, 5); // небольшая задержка, чтобы игрок успел увидеть перемещение
                    return;
                }
            }
        }

        function botUseSecretPath(bot) {
            for (let key in secretPaths) {
                const path = secretPaths[key];

                if (path.from.x === bot.x && path.from.y === bot.y) {
                    bot.x = path.to.x;
                    bot.y = path.to.y;

                    bot.path = [];
                    bot.steps = 0;

                    // Помечаем комнату назначения как посещённую
                    const cellId = matrix[bot.y][bot.x];
                    const cell = cells[cellId];
                    if (cell && cell.type === "room") {
                        bot.visitedRooms = bot.visitedRooms || [];
                        if (!bot.visitedRooms.includes(cell.RoomName)) {
                            bot.visitedRooms.push(cell.RoomName);
                        }
                    }

                    showNotification(`🌀 ${bot.name} воспользовался тайным ходом`, "info");
                    renderBoard();
                    saveGameState();
                    return true;
                }
            }
            return false;
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

        function showEndGameButton() {
            endGameButton.style.display = "inline-block";
        }

        endGameButton.addEventListener("click", () => {
            gamePhase = GamePhase.GAME_OVER;
            resetGame();
            gameActive = false;
            endGameButton.style.display = "none";
        });

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
            const playerCellId = matrix[playerPos.y][playerPos.x];
            const currentRoomId = cells[playerCellId]?.RoomName;

            // Фильтруем только текущую комнату
            const filteredRooms = rooms.filter(r => r.ID == currentRoomId);
            createDropdown(filteredRooms, 'roomSelect');

            // Блокируем выбор
            document.getElementById('roomSelect').disabled = true;
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
                        markKnownCard(playerID, cardName);
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
                            // Перемещаем персонажа в комнату игрока
                            const playerCellId = matrix[playerPos.y][playerPos.x];
                            const roomId = cells[playerCellId]?.RoomName;
                            if (roomId) {
                                for (let y = 0; y < matrix.length; y++) {
                                    for (let x = 0; x < matrix[y].length; x++) {
                                        const cellId = matrix[y][x];
                                        const cell = cells[cellId];
                                        if (cell && cell.type === "room" && cell.RoomName === roomId) {
                                            targetBot.x = playerPos.x;
                                            targetBot.y = playerPos.y;
                                            targetBot.path = [];
                                            targetBot.steps = 0;
                                            targetBot.visitedRooms = targetBot.visitedRooms || [];
                                        }
                                    }
                                }
                            }
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
                isDiceDone = false;
                rollDiceButton.style.display = "none";
                endTurnButton.style.display = "none";
                accuseButton.style.display = "none";
                suggestButton.style.display = "none";
                secretPathButton.style.display = "none";
                modal.style.display = "none";
                accuseModal.style.display = "none";
                gamePhase = GamePhase.PLAYER_TURN;
                currentPlayer = "bot";
                suggestModal.style.display = "none";
                modal.style.display = "block";
                saveGameState();
            } else {
                alert("Пожалуйста, выберите все три карты.");
            }
        });

        modalButton.addEventListener("click", () => {
            modal.style.display = "none";
                    
            if (gamePhase === GamePhase.GAME_OVER) {
                showEndGameButton();
                return;
            }

            if (gamePhase === GamePhase.PLAYER_ELIMINATED) {
                gamePhase = GamePhase.BOT_TURN;
                currentPlayer = "bot";
                setTimeout(botMove, 300);
                return;
            }
                    
            if (gamePhase === GamePhase.PLAYER_TURN) {
                gamePhase = GamePhase.BOT_TURN;
                currentPlayer = "bot";
                setTimeout(botMove, 300);
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
        
        // Автоматическая пометка найденных карт
        function markKnownCard(ownerPlayerID, cardName) {
            const rows = document.querySelectorAll("#cluedo-table tr[data-card-id]");
            rows.forEach(row => {
                const cardTitle = row.querySelector("td:first-child").textContent.trim();
                if (cardTitle === cardName) {
                    const colIndex = playersInfo.findIndex(p => p.id === parseInt(ownerPlayerID));
                    if (colIndex !== -1) {
                        const cell = row.querySelectorAll("td")[colIndex + 1];
                        cell.classList.remove("mark-cross", "mark-question");
                        cell.classList.add("mark-check");
                        cell.innerHTML = "";
                    }
                }
            });
            saveNotebookState();
        }

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
                        document.querySelector("#modal .modal-content h2").textContent =
                            "Вы сделали верное обвинение!";
    
                        gamePhase = GamePhase.GAME_OVER;
                        isGameStarted = false;
                        showEndGameButton();
                    } else {
                        document.querySelector("#modal .modal-content h2").textContent =
                            "Вы сделали неверное обвинение! Вы выбываете из игры.";

                        playerEliminated = true;
                        gamePhase = GamePhase.PLAYER_ELIMINATED;
                        showEndGameButton();
                    }

                    accuseModal.style.display = "none";
                    modal.style.display = "block";

                    // Скрывает все кнопки, игрок больше не участвует в игре
                    accuseButton.style.display = "none";
                    suggestButton.style.display = "none";
                    endTurnButton.style.display = "none";
                    secretPathButton.style.display = "none";
                    rollDiceButton.style.display = "none";

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

        function checkSecretRoomCard(roomId) {
            const secretRoomCards =
                JSON.parse(localStorage.getItem("secretRoomCards")) || {};
            const revealed =
                JSON.parse(localStorage.getItem("revealedSecretCards")) || {};
        
            const cardId = secretRoomCards[roomId];
            if (!cardId || revealed[cardId]) return;
        
            // Помечает как открытую
            revealed[cardId] = true;
            localStorage.setItem(
                "revealedSecretCards",
                JSON.stringify(revealed)
            );

            // Получает данные карты (из общего списка)
            const cardRow = document.querySelector(
                `tr[data-card-id="${cardId}"]`
            );
            if (!cardRow) return;

            const cardName =
                cardRow.querySelector("td:first-child").textContent.trim();

            showNotification(
                `🎁 В комнате вы нашли карту: «${cardName}»`,
                "success",
                7000
            );

            // Автоматически отмечает как карту игрока
            markKnownCard(playerID, cardName);
        }

        function showNotification(text, type = "info", duration = 4500) {
            const container = document.getElementById("notifications");
            const note = document.createElement("div");
            note.className = `notification ${type}`;
            note.textContent = text;

            container.appendChild(note);
            requestAnimationFrame(() => note.classList.add("show"));

            setTimeout(() => {
                note.classList.remove("show");
                setTimeout(() => note.remove(), 300);
            }, duration);
        }

        function pickUnknownCard(cards, knownCards) {
            const unknown = cards.filter(c => !knownCards.includes(c.ID));
            if (unknown.length === 0) return cards[Math.floor(Math.random() * cards.length)];
            return unknown[Math.floor(Math.random() * unknown.length)];
        }

        async function botMakeSuggestion(bot) {
            const cellId = matrix[bot.y][bot.x];
            const cell = cells[cellId];
            if (!cell || cell.type !== "room") return;
        
            const roomId = cell.RoomName;
        
            const roomName = roomIdToName[roomId];
        
            // Загружает карты
            const characters = await loadCardsByType('Character');
            const weapons = await loadCardsByType('Weapon');
        
            // Выбор
            const character = pickUnknownCard(characters, bot.knownCards);
            const weapon = pickUnknownCard(weapons, bot.knownCards);

            // Проверяет, чтобы бот не выбирал свою карту
            const playerCards = await loadCardsByType('Character'); // или свои карты бота
            let chosenCharacter = character;
            if (botHasCard(bot.id, character.ID)) {
                // если бот имеет эту карту, берёт следующую из списка
                const otherCharacters = characters.filter(c => !botHasCard(bot.id, c.ID));
                chosenCharacter = otherCharacters[Math.floor(Math.random() * otherCharacters.length)];
            }

            const cardIDs = [chosenCharacter.ID, weapon.ID, roomId];
            showNotification(`🕵️ ${bot.name} предполагает: ${chosenCharacter.CardName}, ${weapon.CardName}, ${roomName}`, "info");
            
            // Проверка через сервер
            const response = await fetch('checkCards.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ cardIDs, excludePlayerID: bot.id })
            });
            
        const result = await response.json();

        if (!result.noMatch && result.cardID) {
            bot.knownCards = bot.knownCards || [];
            if (!bot.knownCards.includes(result.cardID)) {
                bot.knownCards.push(result.cardID);
                saveGameState();
            }
        }
        
        // Результат для игрока
        if (result.noMatch || parseInt(result.playerID) === bot.id) {
            showNotification("❌ Никто не показал карту", "warn");
        } else {
            const owner = playersInfo.find(p => p.id === parseInt(result.playerID));
            showNotification(`✅ ${owner?.label || "Игрок"} показал карту`, "success");
            }
        }
        
        function botHasCard(botID, cardID) {
            const bot = bots.find(b => b.id === botID);
            if (!bot || !bot.knownCards) return false;
            return bot.knownCards.includes(cardID);
        }

        async function botShouldAccuse(bot) {
            if (bot.eliminated) return false;
            const randomTurnLimit = Math.floor(Math.random() * (15 - 7 + 1)) + 7;
            if (bot.turnsPlayed > randomTurnLimit) return true; 
        
            const characters = await loadCardsByType("Character");
            const weapons = await loadCardsByType("Weapon");
            const rooms = await loadCardsByType("Room");
        
            const unknownCharacters = characters.filter(c => !bot.knownCards.includes(c.ID));
            const unknownWeapons = weapons.filter(w => !bot.knownCards.includes(w.ID));
            const unknownRooms = rooms.filter(r => !bot.knownCards.includes(r.ID));
        }

        async function botMakeAccusation(bot) {
            const characters = await loadCardsByType("Character");
            const weapons = await loadCardsByType("Weapon");
            const rooms = await loadCardsByType("Room");
        
            const character = characters.find(c => !bot.knownCards.includes(c.ID));
            const weapon = weapons.find(w => !bot.knownCards.includes(w.ID));
            const room = rooms.find(r => !bot.knownCards.includes(r.ID));
        
            showNotification(
                `⚖️ ${bot.name} выдвигает обвинение: ${character.CardName}, ${weapon.CardName}, ${room.CardName}`,
                "warn"
            );
        
            const response = await fetch("checkAccusation.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    selectedCards: [character.ID, weapon.ID, room.ID]
                })
            });

            const result = await response.json();
        
            if (result.success) {
                showNotification(`🏆 ${bot.name} победил!`, "success");
                gamePhase = GamePhase.GAME_OVER;
                gameActive = false;
                showEndGameButton();
            } else {
                showNotification(`❌ ${bot.name} ошибся и выбыл`, "error");
                bot.eliminated = true;
                saveGameState();
            }
        }

        function botMove() {
            if (!gameActive) return;
            if (!isGameStarted) return;
            if (gamePhase !== GamePhase.BOT_TURN) return;
            if (isBotMoving) return;
        
            isBotMoving = true;
        
            const bot = bots[currentBot];
        
        bot.knownCards = bot.knownCards || [];
        bot.visitedRooms = bot.visitedRooms || [];
        bot.turnsPlayed = bot.turnsPlayed || 0;

        if (bot.eliminated) {
            isBotMoving = false;
            finishBotTurn();
            return;
        }

        // Использование тайного хода
        if (bot.pendingSecret) {
            bot.pendingSecret = false;
        
            if (botUseSecretPath(bot)) {
                // После тайного хода — предположение и конец хода
                botMakeSuggestion(bot).then(() => {
                    isBotMoving = false;
                    setTimeout(finishBotTurn, 3200);
                });
                return;
            }
        }

        // Увеличивает счётчик ходов
        bot.turnsPlayed = (bot.turnsPlayed || 0) + 1;

        botShouldAccuse(bot).then(shouldAccuse => {

        const cellId = matrix[bot.y][bot.x];
        const cell = cells[cellId];
        const isInRoom = cell && cell.type === "room";

        if (shouldAccuse && !isInRoom) {
        botMakeAccusation(bot).then(() => {
            isBotMoving = false;
            finishBotTurn();
            return;
        });
            } else {
                moveStep();
            }
        });


        // Бросок кубиков для бота
        let currentStep = 0;
        bot.steps = Math.floor(Math.random() * 6 + 1) + Math.floor(Math.random() * 6 + 1);

        // Обновляет статус хода
        document.getElementById("turnStatus").innerText = `Ход: ${bot.name}`;

        function moveStep() {
           if (bot.eliminated) {
                isBotMoving = false;
                finishBotTurn();
                return;
            }
        if (currentStep < bot.steps) {
        const newPos = pathfindingMove(bot);

        if (newPos && (newPos.x !== bot.x || newPos.y !== bot.y)) {
            bot.x = newPos.x;
            bot.y = newPos.y;
        }

        renderBoard();
        saveGameState();

        const cellId = matrix[bot.y][bot.x];
        const cell = cells[cellId];

        if (cell && cell.type === "room" && !bot.inRoom) {
            isBotMoving = false;
            bot.inRoom = true;
        
            if (!bot.visitedRooms.includes(cell.RoomName)) {
                bot.visitedRooms.push(cell.RoomName);
            }

            bot.pendingSecret = true;
            saveGameState();
        
            botMakeSuggestion(bot).then(() => {
                setTimeout(finishBotTurn, 3200);
            });
            return;
        }

        currentStep++;
        setTimeout(moveStep, 450);
        
        } else {
            // Движение завершено
            isBotMoving = false;

            const cellId = matrix[bot.y][bot.x];
            const cell = cells[cellId];

        // Если бот оказался в комнате
        if (cell && cell.type === "room") {
        
            // Сначала тайный ход (если есть)
            botUseSecretPath(bot);
        
            // После тайного хода ОБЯЗАТЕЛЬНО предположение
            botMakeSuggestion(bot).then(() => {
                setTimeout(finishBotTurn, 3200);
            });
        
                } else {
                            finishBotTurn();
                                }
                        }
                }
        }

        function finishBotTurn() {
            saveGameState();
            currentBot = (currentBot + 1) % bots.length;
        
            // Если прошли всех ботов
            if (currentBot === 0) {
                if (!playerEliminated && gamePhase !== GamePhase.GAME_OVER) {
                    // Ход игрока
                    gamePhase = GamePhase.PLAYER_TURN;
                    currentPlayer = "player";
        
                    document.getElementById("turnStatus").innerText = "Ход: Шахризар (Игрок)";

                    endTurnButton.style.display = "inline-block";
                    rollDiceButton.style.display = "inline-block";
                    rollDiceButton.disabled = false;
        
                    isDiceRolled = false;
                    isPlayerTurn = true;
        
                    showSuggestButton();
                    showSecretPathButton();
                    showAccuseButton();
        
                    renderBoard();
                } else {
                    // Игрок выбыл — боты продолжают
                    gamePhase = GamePhase.BOT_TURN;
                    currentPlayer = "bot";
                    setTimeout(botMove, 300);
                }
            } else {
                // Следующий бот
                setTimeout(botMove, 800);
            }
        }

        // Функция поиска пути в указанное место (новую комнату) для бота
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
                    if (cell && cell.type === "room" && !visitedRooms.includes(cell.RoomName)) {
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
                                (
                                    nextCell.type === "room" ||
                                    (nextCell.type === "walkable" && !isCellOccupied(newX, newY))
                                )
                            ){
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
        if (currentCell.type === "room" && bot.inRoom) {
            bot.inRoom = false;
        
            const directions = [
                { x: 1, y: 0 },
                { x: -1, y: 0 },
                { x: 0, y: 1 },
                { x: 0, y: -1 }
            ];
        
            for (const dir of directions) {
                const exitX = bot.x + dir.x;
                const exitY = bot.y + dir.y;
        
                if (
                    exitX >= 0 &&
                    exitY >= 0 &&
                    exitX < matrix[0].length &&
                    exitY < matrix.length
                ) {
                    const exitCell = cells[matrix[exitY][exitX]];
                    if (exitCell?.type === "walkable" && !isCellOccupied(exitX, exitY)) {
                        return { x: exitX, y: exitY };
                    }
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
        resetDiceState();
        rollDiceButton.style.display = "inline-block";
        endTurnButton.style.display = "inline-block";
        playerCards.style.display = "inline-block";
        accuseButton.style.display = "inline-block";
        document.getElementById("turnStatus").innerText = `Ход: Шахризар (Игрок)`;
        currentPlayer = "player"; // Игрок начинает первый ход
        gamePhase = GamePhase.PLAYER_TURN;
        isGameStarted = true;
        gameActive = true;
        playerEliminated = false;
        currentBot = 0;
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
        fetch('getUnusedCards.php')
          .then(res => res.json())
          .then(data => {
            if (!data.success || !data.unusedCards.length) return;
        
            const unusedCards = data.unusedCards;
        
            const roomIds = Object.keys(roomIdToName);
            const shuffledRooms = roomIds.sort(() => Math.random() - 0.5);
        
            const secretRoomCards = {};
            unusedCards.forEach((card, index) => {
              const roomId = shuffledRooms[index % shuffledRooms.length];
              secretRoomCards[roomId] = card.ID;
            });
        
            localStorage.setItem("secretRoomCards", JSON.stringify(secretRoomCards));
            localStorage.setItem("revealedSecretCards", JSON.stringify({}));
          });
        });

        function resetDiceState() {
            diceSum = 0;
            diceSumEl.textContent = "0";
            dice1El.textContent = '⚀';
            dice2El.textContent = '⚀';
            diceSum_cont.style.display = "none";
            isDiceRolled = false;
            rollDiceButton.disabled = false;
            document.querySelectorAll(".cell.highlight").forEach(cell => {
                cell.classList.remove("highlight");
                cell.removeEventListener("click", handleCellClick);
            });
        }

        // Обработчик кнопки "Завершить ход"
        endTurnButton.addEventListener("click", () => {
            if (currentPlayer === "player") {
                // Игрок завершил ход
                resetDiceState();
                isDiceDone = false;
                currentBot = 0; 
                currentPlayer = "bot"; // Следующий ход - первый бот
                accuseButton.style.display = "none";
                modal.style.display = "none";
                suggestButton.style.display = "none";
                secretPathButton.style.display = "none";
                endTurnButton.style.display = "none";
                rollDiceButton.style.display = "none";
                saveGameState();
                gamePhase = GamePhase.BOT_TURN;
                setTimeout(botMove, 300); // Перемещает первого бота
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
        isDiceDone = false;
        let isDiceRolled = false; // Флаг, что кости подброшены
        let isPlayerTurn = false; // Флаг, что сейчас ход игрока

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
            isDiceDone = true;
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
                resetDiceState();

                // Проверка комнаты и кнопок
                const cellId = matrix[playerPos.y][playerPos.x];
                const cellType = cells[cellId]?.type;
                if (cellType === "room") {
                    checkSecretRoomCard(cells[cellId].RoomName);
                }
                if (cellType === "room") {
                    rollDiceButton.disabled = true;
                    rollDiceButton.style.display = "none";
                    showSuggestButton();
                } else {
                    if (currentPlayer === "player") {
                        // Игрок завершил ход
                        rollDiceButton.style.display = "none";
                        currentBot = 0;
                        currentPlayer = "bot"; // Следующий ход - первый бот
                        endTurnButton.style.display = "none";
                        modal.style.display = "none";
                        suggestButton.style.display = "none";
                        secretPathButton.style.display = "none";
                        accuseButton.style.display = "none";
                        saveGameState();
                        gamePhase = GamePhase.BOT_TURN;
                        setTimeout(botMove, 300); // Перемещает первого бота
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
                        // div.innerText = "";
                    }

                    // Боты
                    for (let i = 0; i < bots.length; i++) {
                        if (bots[i].x === x && bots[i].y === y) {
                            div.classList.add("player");
                            // div.innerText = bots[i].token;
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
                    cell.classList.add('mark-question');
                } else if (cell.classList.contains('mark-question')) {
                    cell.classList.remove('mark-question');
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
                    } else if (cell.classList.contains("mark-question")) {
                        notebookState[cardId][index - 1] = "question";
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

                        if (mark === "cross") cell.classList.add("mark-cross");
                        if (mark === "check") cell.classList.add("mark-check");
                        if (mark === "question") cell.classList.add("mark-question");
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
                    }
                }
            });
        }

        [suggestModal, accuseModal, modal].forEach(m => {
            m.addEventListener("click", (e) => {
                if (e.target === m) {
                    m.style.display = "none";
                }
            });
        });

        renderBoard();
        initNotebookHeader();
        showAccuseButton();
        showSuggestButton();
        showSecretPathButton();
        restoreGameState();
    </script>
</body>

</html>

<!-- Игра реализует пошаговую браузерную версию Cluedo с разделением логики на клиентскую и серверную части. Клиент отвечает за отображение поля, интерфейс, анимацию ходов и ввод действий игрока, тогда как вся критически важная игровая логика, связанная с картами, проверками предположений и обвинений, вынесена на сервер и реализована через AJAX-запросы. Это позволяет избежать хранения «секретной» информации на клиенте и приблизить поведение игры к реальному онлайн-варианту.

При нажатии кнопки «Начать игру» клиент инициирует создание игровой сессии, отправляя AJAX-запрос на серверный скрипт createGameSession.php. Сервер на этом этапе формирует скрытое решение дела (персонаж, оружие, комната), раздаёт карты между игроком и ботами, сохраняет это состояние в базе данных и возвращает клиенту только допустимую информацию — карты игрока. Клиент отображает их визуально, но не знает ни решения, ни карт других участников, что является ключевым принципом архитектуры.

Во время игры все действия, связанные с картами, выполняются через сервер. Когда игрок или бот делает предположение, клиент формирует запрос с идентификаторами выбранных карт и отправляет его на сервер (checkCards.php). Сервер проверяет, есть ли хотя бы у одного из других участников одна из указанных карт, и возвращает строго ограниченный ответ: либо факт отсутствия совпадений, либо имя игрока и название одной карты. Таким образом, клиент не получает доступ к полной информации, а лишь к результату проверки. Этот же механизм используется и для логики ботов, которые делают предположения автоматически и пополняют свой список известных карт на основании серверного ответа.

Загрузка самих карт (персонажей, оружия, комнат) также происходит через AJAX. При открытии модальных окон предположения или обвинения клиент запрашивает у сервера списки карт по типу (getCards.php), что позволяет хранить их централизованно в базе данных и не дублировать в JavaScript. Это упрощает масштабирование и изменение состава карт без переписывания клиентского кода.

Обвинение игрока или бота проверяется исключительно сервером через запрос к checkAccusation.php. Клиент отправляет выбранные карты, сервер сравнивает их с заранее сохранённым решением дела и возвращает только результат — верное или неверное обвинение. В случае успеха сервер подтверждает победу, а при ошибке сообщает о поражении, после чего клиент лишь визуально обновляет состояние игры. Таким образом, клиент физически не способен «угадать» решение без сервера, что демонстрирует корректное разделение ответственности.

Дополнительно используется AJAX-запрос getUnusedCards.php, который возвращает карты, не участвующие в основном деле. Эти карты случайным образом распределяются по комнатам как скрытые бонусы, но и здесь клиент получает только разрешённую информацию, а логика выбора остаётся на стороне сервера.

Поведение ботов построено по тому же принципу, что и действия игрока. Боты не имеют доступа к решению и взаимодействуют с сервером через те же самые AJAX-эндпоинты: они делают предположения, получают ответы, накапливают знания и при достаточном количестве информации отправляют обвинение на сервер. Сервер одинаково обрабатывает обвинения как игрока, так и ботов, что подчёркивает единый игровой механизм.

В результате архитектура игры строится по чёткому принципу: клиент — это интерфейс и управление, сервер — источник истины. Все ключевые проверки, работа с картами, логика выигрыша и проигрыша реализованы через AJAX-запросы к PHP-скриптам, что делает игру устойчивой к подмене данных, логически цельной и максимально приближённой к настоящей сетевой игре, даже при однопользовательском формате. -->