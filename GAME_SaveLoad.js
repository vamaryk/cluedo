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