        // Отображение кнопки для тайного хода
        function showSecretPathButton() {
            if (
                !isGameStarted ||
                currentPlayer !== "player" ||
                isDiceDone 
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

secretPathButton.addEventListener("click", useSecretPath);