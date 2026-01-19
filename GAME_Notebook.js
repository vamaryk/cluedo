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