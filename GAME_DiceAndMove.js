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