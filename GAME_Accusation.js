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