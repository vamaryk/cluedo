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

        function botHasCard(botID, cardID) {
            const bot = bots.find(b => b.id === botID);
            if (!bot || !bot.knownCards) return false;
            return bot.knownCards.includes(cardID);
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