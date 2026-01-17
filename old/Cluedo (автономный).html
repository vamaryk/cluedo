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
      margin: 30px;
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

    .empty { background: #3CB371; border: none; }
    .walkable { background: #F4A460; }
    .blocked { background: #C0C0C0; }

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

    .cell.border-top { border-top: 3px solid #5c4033; }
    .cell.border-right { border-right: 3px solid #5c4033; }
    .cell.border-bottom { border-bottom: 3px solid #5c4033; }
    .cell.border-left { border-left: 3px solid #5c4033; }

    /* Кнопка предположения */
    #suggestButton {
      margin-top: 20px;
      padding: 15px 30px;
      font-size: 18px;
      cursor: pointer;
      display: none;
      background-color: #f39c12;
      color: white;
      border: 2px solid #e67e22;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transition: background-color 0.3s, transform 0.3s;
    }

    /* При наведении на кнопку */
    #suggestButton:hover {
      background-color: #e67e22;
      transform: scale(1.05);
    }

    /* Окно уведомления */
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
      margin-top: 10px;
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
  </style>
</head>
<body>

  <div id="board" class="grid"></div>

  <button id="suggestButton" style="display: none;">Сделать предположение</button>

  <button id="secretPathButton" style="display: none;">Воспользоваться тайным ходом</button>

  <div id="modal">
    <p>Вы сделали предположение.</p>
    <button id="modalButton">Ок</button>
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
      3: { id: 3, type: "room" },
      4: { id: 4, type: "room" },
      5: { id: 5, type: "room" },
      6: { id: 6, type: "room" },
      7: { id: 7, type: "room" },
      8: { id: 8, type: "room" },
      9: { id: 9, type: "room" },
      10: { id: 10, type: "room" },
      11: { id: 11, type: "room" },
      12: { id: 12, type: "room" },
      13: { id: 13, type: "room" },
      14: { id: 14, type: "room" },
      15: { id: 15, type: "room" },
      16: { id: 16, type: "room" },
      17: { id: 17, type: "room" },
      18: { id: 18, type: "room" },
      19: { id: 19, type: "room" },
      20: { id: 20, type: "room" }
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

    let playerPos = JSON.parse(localStorage.getItem("playerPos")) || { x: 10, y: 1 };

    const board = document.getElementById("board");

    const suggestButton = document.getElementById("suggestButton");
    const secretPathButton = document.getElementById("secretPathButton");
    const modal = document.getElementById("modal");
    const modalButton = document.getElementById("modalButton");

    // Поиск, какие клетки (ID) относятся к указанной комнате
    function fetchRoomCellsByRoomName(roomName) {
      fetch(`getRoomCellsByRoomName.php?roomName=${roomName}`)
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            console.error("Ошибка при получении клеток комнаты:", data.error);
          } else {
            console.log(`Клетки комнаты с RoomName ${roomName}:`, data);
            // Здесь можно дальше обрабатывать полученные клетки
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

        // Передаем cellId в fetchRoomName
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

    // Отображение кнопки для тайного хода
    function showSecretPathButton() {
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

    // Функция для использования тайного хода
    function useSecretPath() {
      // Проверка, связана ли текущая клетка с потайным ходом
      for (let path in secretPaths) {
        if (secretPaths[path].from.x === playerPos.x && secretPaths[path].from.y === playerPos.y) {
          playerPos = { x: secretPaths[path].to.x, y: secretPaths[path].to.y };
          savePlayerPos();  // Сохранение новой позиции
          renderBoard();    // Отображение обновлённой карты
          showSuggestButton();  // Проверка, нужно ли показывать кнопку для предположения
          showSecretPathButton(); // Проверка, нужно ли показывать кнопку для тайного хода
          return;
        }
      }
    }

    // Обработчик на кнопку для тайного хода
    secretPathButton.addEventListener("click", useSecretPath);

    // Отображение кнопки для предположения
    function showSuggestButton() {
      const cellId = matrix[playerPos.y][playerPos.x];
      const cell = cells[cellId];
      if (cell && cell.type === "room") {
        suggestButton.style.display = "inline-block"; // Показать кнопку
      } else {
        suggestButton.style.display = "none"; // Скрыть кнопку
      }
    }

    // Открыть модальное окно при нажатии на кнопку
    suggestButton.addEventListener("click", () => {
      modal.style.display = "block"; // Показать модальное окно
    });

    // Закрыть модальное окно при нажатии на "Ок"
    modalButton.addEventListener("click", () => {
      modal.style.display = "none"; // Скрыть модальное окно
    });

    // Отображение поля
    function renderBoard() {
      board.innerHTML = "";
      for (let y = 0; y < matrix.length; y++) {
        for (let x = 0; x < matrix[0].length; x++) {
          const cellId = matrix[y][x];
          const div = document.createElement("div");
          div.classList.add("cell");

          if (cellId === 0) {
            div.classList.add("empty");
          } else {
            const cell = cells[cellId];
            div.classList.add(cell.type);

            // Границы для пустых клеток комнат (серых)
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
            div.innerText = "👳🏾‍";
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
        matrix[y][x] !== 2 // Запрет ходить на заблокированные клетки
      );
    }

    function savePlayerPos() {
      localStorage.setItem("playerPos", JSON.stringify(playerPos));
    }

    // Управление движением игрока
    document.addEventListener("keydown", (e) => {
      let { x, y } = playerPos;
      if (e.key === "ArrowUp" || e.key === "w") y--;
      if (e.key === "ArrowDown" || e.key === "s") y++;
      if (e.key === "ArrowLeft" || e.key === "a") x--;
      if (e.key === "ArrowRight" || e.key === "d") x++;

      if (canMove(x, y)) {
        playerPos = { x, y };
        savePlayerPos();
        renderBoard();
        showSuggestButton();
        showSecretPathButton();
      }
    });

    renderBoard();
    showSuggestButton();
    showSecretPathButton();
  </script>
</body>
</html>




