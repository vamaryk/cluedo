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