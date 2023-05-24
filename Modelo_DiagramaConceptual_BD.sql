CREATE TABLE User (
    UserID INT PRIMARY KEY,
    FullName VARCHAR(255),
    BirthYear INT,
    Gender VARCHAR(20),
    Country VARCHAR(255),
    City VARCHAR(255),
    Email VARCHAR(255),
    Password VARCHAR(255),
    Username VARCHAR(255),
    ProfilePicture VARCHAR(255),
    AccountStatus VARCHAR(20),
    Rol VARCHAR(255)
);

-- Inserción de datos en la tabla User
INSERT INTO User (UserID, FullName, BirthYear, Gender, Country, City, Email, Password, Username, ProfilePicture, AccountStatus,Rol)
VALUES (1, 'John Doe', 1990, 'Male', 'United States', 'New York', 'johndoe@example.com', 'password123', 'johndoe123', 'profile.jpg', 'Active','user');

INSERT INTO User (UserID, FullName, BirthYear, Gender, Country, City, Email, Password, Username, ProfilePicture, AccountStatus,Rol)
VALUES (2, 'Jane Smith', 1985, 'Female', 'Canada', 'Toronto', 'janesmith@example.com', 'password456', 'janesmith789', 'profile.jpg', 'Active','admin');


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
