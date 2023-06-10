CREATE TABLE User (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    FullName VARCHAR(255),
    BirthYear INT,
    Gender VARCHAR(20),
    Country VARCHAR(255),
    City VARCHAR(255),
    Email VARCHAR(255),
    Password VARCHAR(255),
    Username VARCHAR(255),
    ProfilePicture VARCHAR(255),
    QrPicture TEXT,
    AccountStatus VARCHAR(20),
    Rol VARCHAR(255)
);

-- Inserción de datos en la tabla User
INSERT INTO User (UserID, FullName, BirthYear, Gender, Country, City, Email, Password, Username, ProfilePicture, AccountStatus,Rol)
VALUES (1, 'John Doe', 1990, 'Male', 'United States', 'New York', 'johndoe@example.com', 'password123', 'johndoe123', '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', 'Active','user');

INSERT INTO User (UserID, FullName, BirthYear, Gender, Country, City, Email, Password, Username, ProfilePicture, AccountStatus,Rol)
VALUES (2, 'Jane Smith', 1985, 'Female', 'Canada', 'Toronto', 'janesmith@example.com', 'password456', 'janesmith789', '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', 'Active','admin');


-- Creación de la tabla Game (Juego)
CREATE TABLE Game (
GameID INT PRIMARY KEY,
UserID INT,
Score INT,
Result VARCHAR(20),
FOREIGN KEY (UserID) REFERENCES User(UserID)
);

-- Inserción de datos en la tabla Game
INSERT INTO Game (GameID, UserID, Score, Result)
VALUES (1, 1, 10, 'Win');

INSERT INTO Game (GameID, UserID, Score, Result)
VALUES (2, 1, 5, 'Loss');

INSERT INTO Game (GameID, UserID, Score, Result)
VALUES (3, 2, 8, 'Win');


-- Creación de la tabla Question (Pregunta)
CREATE TABLE Question (
QuestionID INT PRIMARY KEY,
Category VARCHAR(255),
Text VARCHAR(255),
CorrectAnswer CHAR(1)
);

-- Inserción de datos en la tabla Question
INSERT INTO Question (QuestionID, Category, Text, CorrectAnswer)
VALUES (1, 'History', 'Who was the first president of the United States?', 'A');

INSERT INTO Question (QuestionID, Category, Text, CorrectAnswer)
VALUES (2, 'Sports', 'Which country won the FIFA World Cup in 2018?', 'B');

INSERT INTO Question (QuestionID, Category, Text, CorrectAnswer)
VALUES (3, 'Culture', 'Who painted the Mona Lisa?', 'C');


-- Creación de la tabla ReportedQuestion (Pregunta reportada)
CREATE TABLE ReportedQuestion (
ReportID INT PRIMARY KEY,
QuestionID INT,
UserID INT,
ReportReason VARCHAR(255),
Status VARCHAR(20),
FOREIGN KEY (QuestionID) REFERENCES Question(QuestionID),
FOREIGN KEY (UserID) REFERENCES User(UserID)
);

-- Inserción de datos en la tabla ReportedQuestion
INSERT INTO ReportedQuestion (ReportID, QuestionID, UserID, ReportReason, Status)
VALUES (1, 1, 2, 'Incorrect answer choices', 'Pending');

INSERT INTO ReportedQuestion (ReportID, QuestionID, UserID, ReportReason, Status)
VALUES (2, 2, 1, 'Grammatical error in the question', 'Resolved');
