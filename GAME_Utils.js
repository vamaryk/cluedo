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