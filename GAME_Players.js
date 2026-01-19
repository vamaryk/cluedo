        // Стартовые координаты игроков и ботов
        let playerPos = JSON.parse(localStorage.getItem("playerPos")) || { x: 9, y: 25 };

        // Фиксированные фишки (ID) начальные позиции для ботов
        let bots = [
            { id: 1, name: "Надира", x: 10, y: 1, token: "", steps: 0, visitedRooms: [], knownCards: [], turnsPlayed: 0, eliminated: false, pendingSecret: false },
            { id: 2, name: "Эмине", x: 16, y: 1, token: "", steps: 0, visitedRooms: [], knownCards: [], turnsPlayed: 0, eliminated: false, pendingSecret: false },
            { id: 3, name: "Орхан", x: 25, y: 7, token: "", steps: 0, visitedRooms: [], knownCards: [], turnsPlayed: 0, eliminated: false, pendingSecret: false },
            { id: 4, name: "Малхун", x: 1, y: 17, token: "", steps: 0, visitedRooms: [], knownCards: [], turnsPlayed: 0, eliminated: false, pendingSecret: false }
        ];

        const playersInfo = [
            { id: 1, label: "Игрок 1: Надира", icon: "نادره" },
            { id: 2, label: "Игрок 2: Эмине", icon: "آمنه" },
            { id: 3, label: "Игрок 3: Орхан", icon: "اورخان" },
            { id: 4, label: "Игрок 4: Малхун", icon: "مالحون" },
            { id: 5, label: "Игрок 5: Шахризар", icon: "شهريزار‍" }
        ];

        function initNotebookHeader() {
            const headerRow = document.querySelector("#cluedo-table tr:first-child");
            const cells = headerRow.querySelectorAll("td");
            playersInfo.forEach((player, index) => {
                cells[index + 1].textContent = player.label;
            });
        }