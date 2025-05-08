CREATE DATABASE cluedo_db;
USE cluedo_db;

CREATE TABLE Users (
    ID SERIAL PRIMARY KEY,
    UserName VARCHAR(50) NOT NULL UNIQUE,
    Email VARCHAR(100) NOT NULL UNIQUE,
    PasswordHash VARCHAR(255) NOT NULL,
    CreationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    AvatarURL VARCHAR(255) DEFAULT NULL,
    GamesPlayed INT DEFAULT 0,
    GamesWon INT DEFAULT 0,
    WrongAccusationsAmount INT DEFAULT 0
);

CREATE TABLE Friends (
    Friend INT REFERENCES Users(ID) ON DELETE CASCADE,
    FriendOwner INT REFERENCES Users(ID) ON DELETE CASCADE,
    FriendStatus ENUM('Pending', 'Accepted', 'Blocked') NOT NULL DEFAULT 'Pending',
    PRIMARY KEY (Friend, FriendOwner),
    CHECK (Friend < FriendOwner)
);

CREATE TABLE ChatMessages (
    ID SERIAL PRIMARY KEY,
    MessageSender INT REFERENCES Users(ID) ON DELETE CASCADE,
    MessageReciver INT REFERENCES Users(ID) ON DELETE CASCADE,
    MesssageText TEXT NOT NULL,
    MessageDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Cards (
    ID SERIAL PRIMARY KEY,
    CardName VARCHAR(20) NOT NULL UNIQUE,
    CardImageURL VARCHAR(255) NOT NULL UNIQUE,
    CardType VARCHAR(20) NOT NULL,
    CardDescription TEXT
);

CREATE TABLE Chips (
    ID SERIAL PRIMARY KEY,
    ChipCharacter INT REFERENCES Card(ID) ON DELETE CASCADE,
    ChipDefaultCoordinateX INT NOT NULL,
    ChipDefaultCoordinateY INT NOT NULL,
    UNIQUE (ChipCharacter),
    CONSTRAINT UniqueCoordinates UNIQUE (ChipDefaultCoordinateX, ChipDefaultCoordinateY)
);

CREATE TABLE Games (
    ID SERIAL PRIMARY KEY,
    GameHost INT REFERENCES Users(ID) ON DELETE SET NULL,
    GameName VARCHAR(20) NOT NULL, 
    GameStatus ENUM('Waiting', 'InProgress', 'Finished') NOT NULL DEFAULT 'Waiting',
    GameMode Enum('TwoPlayers', 'ManyPlayers') NOT NULL DEFAULT 'ManyPlayers',
    GamePrivacy ENUM('Open', 'Closed') NOT NULL DEFAULT 'Open',
    GamePasswordHash VARCHAR(255),
    GamePlayersAmount INT NOT NULL,
    SolutionCharacter INT REFERENCES Card(ID) ON DELETE SET NULL,
    SolutionWeapon INT REFERENCES Card(ID) ON DELETE SET NULL,
    SolutionRoom INT REFERENCES Card(ID) ON DELETE SET NULL
);

CREATE TABLE GameChatMessages (
    ID SERIAL PRIMARY KEY,
    MessageGame INT REFERENCES Games(ID) ON DELETE CASCADE,
    MessageCreator INT REFERENCES Users(ID) ON DELETE CASCADE,
    MesssageText TEXT NOT NULL,
    MessageDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE GamePlayers (
    GamePlayerID INT REFERENCES Games(ID) ON DELETE CASCADE,
    PlayerUser INT REFERENCES Users(ID) ON DELETE CASCADE,
    PlayerChip INT REFERENCES Chips(ID) ON DELETE CASCADE,
    PlayerGameStatus ENUM('Active', 'Eliminated') NOT NULL DEFAULT 'Active',
    PlayerCurrentCoordinateX INT,
    PlayerCurrentCoordinateY INT,
    PlayerIsWinner BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY (GamePlayerID)
);

CREATE TABLE GameCards ( 
    CardPlayer INT REFERENCES GamePlayers(ID) ON DELETE CASCADE, 
    CardName INT REFERENCES Cards(ID) ON DELETE CASCADE, 
    PRIMARY KEY (CardPlayer, CardName) 
);

CREATE TABLE RoomCells (
    ID SERIAL PRIMARY KEY, 
    RoomName INT REFERENCES Cards(ID) ON DELETE CASCADE,
    CellCoordinateX INT NOT NULL,
    CellCoordinateY INT NOT NULL,
    CONSTRAINT UniqueCellCoordinates UNIQUE (CellCoordinateX, CellCoordinateY)
);

CREATE TABLE SecretPassages (
    SecretPassageID INT REFERENCES RoomCells(ID) ON DELETE CASCADE, 
    Destination INT REFERENCES Cards(ID) ON DELETE CASCADE, 
    PRIMARY KEY (SecretPassageID) 
);

CREATE TABLE GuessesBlankMarks (
    ID SERIAL PRIMARY KEY,
    MarkOwner INT REFERENCES GamePlayers(ID) ON DELETE CASCADE,
    MarkedPlayer INT REFERENCES GamePlayers(ID) ON DELETE CASCADE,
    MarkedCard INT REFERENCES Cards(ID) ON DELETE CASCADE,
    Mark ENUM('✓', 'x', '?', ' ') NOT NULL DEFAULT ' ',
    CONSTRAINT UniqueMark UNIQUE (MarkedPlayer, MarkedCard)
);

CREATE TABLE GameGuesses (
    ID SERIAL PRIMARY KEY,
    GuessPlayer INT REFERENCES GamePlayers(ID) ON DELETE CASCADE, 
    SuspectCharacter INT REFERENCES Cards(ID) ON DELETE CASCADE, 
    SuspectWeapon INT REFERENCES Cards(ID) ON DELETE CASCADE, 
    SuspectRoom INT REFERENCES Cards(ID) ON DELETE CASCADE,  
    GuessType ENUM('Guess', 'Accusation', 'RightAccusation', 'WrongAccusation') NOT NULL DEFAULT 'Guess',
    GuessDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO Cards (CardName, CardImageURL, CardType, CardDescription) VALUES
('Надира', './img/Надира.png', 'character', 'Калфа'),
('Эмине', './img/Эмине.png', 'character', 'Парфюмерша гарема'),
('Орхан', './img/Орхан.png', 'character', ' Архитектор галерей '),
('Малхун', './img/Малхун.png', 'character', 'Баш-хасеки'),
('Шахризар', './img/Шахризар.png', 'character', 'Придворный каллиграф');

INSERT INTO Cards (CardName, CardImageURL, CardType, CardDescription) VALUES
('Кинжал Джамбия', './img/Джамбия.png', 'weapon', 'Ритуальный йеменский кинжал с полым лезвием для яда'),
('Наргиле', './img/Наргиле.png', 'weapon', 'Курительный прибор у восточных народов, сходный с кальяном'),
('Фирдоуси', './img/Фирдоуси.png', 'weapon', 'Фирдоуси "Сердце льва". Персидский боевой молот с шипами'),
('Газель', './img/Газель.png', 'weapon', 'Бронзовая статуэтка'),
('Шёлковый шнур', './img/Шнур.png', 'weapon', 'Шёлковый шнур');

INSERT INTO Cards (CardName, CardImageURL, CardType, CardDescription) VALUES
('Покои', './img/Покои.png', 'room', 'Описание покоев'),
('Павильон', './img/Павильон.png', 'room', 'Описание павильона'),
('Галерея', './img/Галерея.png', 'room', 'Описание галереи'),
('Кухня', './img/Кухня.png', 'room', 'Описание кухни'),
('Макад', './img/Макад.png', 'room', 'Описание макада'),
('Тахтабош', './img/Тахтабош.png', 'room', 'Описание тахтабоша'),
('Сад', './img/Сад.png', 'room', 'Описание сада'),
('Хамам', './img/Хамам.png', 'room', 'Описание хамама'),
('Сокровищница', './img/Сокровищница.png', 'room', 'Описание сокровищницы');

-- Костыль
INSERT INTO RoomCells (RoomName, CellCoordinateX, CellCoordinateY) VALUES
(0, -1, -1), (0, 0, 0);

-- Покои
INSERT INTO RoomCells (RoomName, CellCoordinateX, CellCoordinateY) VALUES
(11, 3, 7), (11, 4, 7);

-- Павильон
INSERT INTO RoomCells (RoomName, CellCoordinateX, CellCoordinateY) VALUES
(12, 10, 7), (12, 16, 7);

-- Галерея
INSERT INTO RoomCells (RoomName, CellCoordinateX, CellCoordinateY) VALUES
(13, 20, 5), (13, 21, 6);

-- Кухня
INSERT INTO RoomCells (RoomName, CellCoordinateX, CellCoordinateY) VALUES
(14, 3, 10), (14, 7, 13), (14, 7, 14);

-- Макад
INSERT INTO RoomCells (RoomName, CellCoordinateX, CellCoordinateY) VALUES
(15, 19, 12);

-- Тахтабош
INSERT INTO RoomCells (RoomName, CellCoordinateX, CellCoordinateY) VALUES
(16, 21, 17), (16, 22, 17), (16, 21, 21), (16, 22, 21);

-- Сад
INSERT INTO RoomCells (RoomName, CellCoordinateX, CellCoordinateY) VALUES
(17, 4, 21), (17, 6, 23);

-- Хамам
INSERT INTO RoomCells (RoomName, CellCoordinateX, CellCoordinateY) VALUES
(18, 13, 19);

-- Сокровищница
INSERT INTO RoomCells (RoomName, CellCoordinateX, CellCoordinateY) VALUES
(19, 24, 24);

INSERT INTO SecretPassages (SecretPassageID, Destination) VALUES
(3, 19), (4, 19), (20, 11), (7, 17), (8, 17), (17, 13), (18, 13);

INSERT INTO Chips (ChipCharacter, ChipDefaultCoordinateX, ChipDefaultCoordinateY) VALUES
(1, 10, 1),
(2, 16, 1),
(3, 25, 7),
(4, 1, 17),
(5, 9, 25);




