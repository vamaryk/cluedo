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

renderBoard();
initNotebookHeader();
showAccuseButton();
showSuggestButton();
showSecretPathButton();
restoreGameState();