// Флаг активной игры
let gameActive = true;

// Фишка (ID) игрока
const playerID = 5;

// Ход игры
let currentPlayer = "player";
let currentBot = 0;

// Блокировки
let isBotMoving = false;
let isGameStarted = false;
let playerEliminated = false;

// Фазы игры
const GamePhase = {
    INIT: "init",
    PLAYER_TURN: "player_turn",
    BOT_TURN: "bot_turn",
    PLAYER_ELIMINATED: "player_eliminated",
    GAME_OVER: "game_over"
};

let gamePhase = GamePhase.INIT;
