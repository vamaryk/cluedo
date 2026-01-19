        // Отображение поля
        function renderBoard() {
            board.innerHTML = "";
            for (let y = 0; y < matrix.length; y++) {
                for (let x = 0; x < matrix[0].length; x++) {
                    const cellId = matrix[y][x];
                    const div = document.createElement("div");
                    div.classList.add("cell");
                    div.setAttribute("data-x", x);
                    div.setAttribute("data-y", y);

                    if (cellId === 0) {
                        div.classList.add("empty");
                    } else {
                        const cell = cells[cellId];
                        div.classList.add(cell.type);

                        // Границы для заблокированных клеток комнат (серых)
                        if (cell.type === "blocked") {
                            const neighbor = (dx, dy) => {
                                const nx = x + dx;
                                const ny = y + dy;
                                if (ny >= 0 && ny < matrix.length && nx >= 0 && nx < matrix[0].length) {
                                    const nid = matrix[ny][nx];
                                    return cells[nid]?.type || "empty";
                                }
                                return "empty";
                            };

                            if (neighbor(0, -1) !== "blocked") div.classList.add("border-top");
                            if (neighbor(1, 0) !== "blocked") div.classList.add("border-right");
                            if (neighbor(0, 1) !== "blocked") div.classList.add("border-bottom");
                            if (neighbor(-1, 0) !== "blocked") div.classList.add("border-left");

                            if (neighbor(0, -1) === "blocked") div.style.borderTop = "none";
                            if (neighbor(1, 0) === "blocked") div.style.borderRight = "none";
                            if (neighbor(0, 1) === "blocked") div.style.borderBottom = "none";
                            if (neighbor(-1, 0) === "blocked") div.style.borderLeft = "none";

                            if (neighbor(0, -1) === "room") div.style.borderTop = "none";
                            if (neighbor(1, 0) === "room") div.style.borderRight = "none";
                            if (neighbor(0, 1) === "room") div.style.borderBottom = "none";
                            if (neighbor(-1, 0) === "room") div.style.borderLeft = "none";
                        }

                        // Границы для клеток поля (желтых)
                        if (cell.type === "walkable") {
                            const neighbor = (dx, dy) => {
                                const nx = x + dx;
                                const ny = y + dy;
                                if (ny >= 0 && ny < matrix.length && nx >= 0 && nx < matrix[0].length) {
                                    const nid = matrix[ny][nx];
                                    return cells[nid]?.type || "empty";
                                }
                                return "empty";
                            };

                            if (neighbor(0, -1) == "empty") div.classList.add("border-top");
                            if (neighbor(1, 0) == "empty") div.classList.add("border-right");
                            if (neighbor(0, 1) == "empty") div.classList.add("border-bottom");
                            if (neighbor(-1, 0) == "empty") div.classList.add("border-left");
                        }
                    }

                    if (playerPos.x === x && playerPos.y === y) {
                        div.classList.add("player");
                        // div.innerText = "";
                    }

                    // Боты
                    for (let i = 0; i < bots.length; i++) {
                        if (bots[i].x === x && bots[i].y === y) {
                            div.classList.add("player");
                            // div.innerText = bots[i].token;
                        }
                    }
                    board.appendChild(div);
                }
            }
        }
