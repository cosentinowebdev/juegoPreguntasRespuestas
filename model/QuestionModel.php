<?php

class QuestionModel {

    private $database;

    public function __construct($database) {
        $this->database = $database;
    }


    public function getQuestionById($questionId) {
        $sql = "SELECT * FROM Questions WHERE QuestionID = ?";
        $stmt = $this->database->prepare($sql);
        
        if (!$stmt) {
            // Error al preparar la consulta
            return null;
        }
        
        $stmt->bind_param("s", $questionId);
        
        if (!$stmt->execute()) {
            // Error al ejecutar la consulta
            return null;
        }
        
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            // No se encontró ningún usuario con el ID proporcionado
            return null;
        }
        
        $question = $result->fetch_assoc();
        return $question;
    }
    public function getQuestionByIdUpdate($questionId) {
        $sql = "SELECT Questions.*, 
                       Categories.CategoryName AS CorrelatedCategory,
                       CASE WHEN Questions.CategoryID = Categories.CategoryID THEN 1 ELSE 0 END AS IsCorrelatedCategory,
                       States.StateName AS CorrelatedState,
                       CASE WHEN Questions.StateID = States.StateID THEN 1 ELSE 0 END AS IsCorrelatedState
                FROM Questions
                LEFT JOIN Categories ON Questions.CategoryID = Categories.CategoryID
                LEFT JOIN States ON Questions.StateID = States.StateID
                WHERE Questions.QuestionID = ?";
        $stmt = $this->database->prepare($sql);
        
        if (!$stmt) {
            // Error al preparar la consulta
            return null;
        }
        
        $stmt->bind_param("s", $questionId);
        
        if (!$stmt->execute()) {
            // Error al ejecutar la consulta
            return null;
        }
        
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            // No se encontró ninguna pregunta con el ID proporcionado
            return null;
        }
        
        $question = $result->fetch_assoc();
        return $question;
    }

    public function getRandomQuestion() {
        // Generar una consulta SQL para obtener una pregunta aleatoria
        $sql = "SELECT q.*, c.* FROM Questions q 
        JOIN Categories c ON q.CategoryID = c.CategoryID 
        WHERE q.StateID = 1
        ORDER BY RAND() LIMIT 1";
        
        // Ejecutar la consulta en la base de datos
        $stmt = $this->database->prepare($sql);
    
        // Verificar si la consulta se ejecutó correctamente
        if (!$stmt) {
            // Error al preparar la consulta
            return null;
        }
        if (!$stmt->execute()) {
            // Error al ejecutar la consulta
            return null;
        }

        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            // No se encontró ningún usuario con el ID proporcionado
            return null;
        }
        
        $question = $result->fetch_assoc();
        return $question;
    }
    public function incrementIncorrectCount($questionID) {
        // Generar una consulta SQL para incrementar IncorrectCount en 1
        $sql = "UPDATE Questions SET IncorrectCount = IncorrectCount + 1 WHERE QuestionID = ?";

        // Preparar la consulta
        $stmt = $this->database->prepare($sql);

        // Verificar si la consulta se preparó correctamente
        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }

        // Vincular el parámetro de la consulta
        $stmt->bind_param("i", $questionID);

        // Ejecutar la consulta
        $result = $stmt->execute();

        // Cerrar la consulta y devolver el resultado
        $stmt->close();
        return $result;
    }

    public function incrementCorrectCount($questionID) {
        // Generar una consulta SQL para incrementar CorrectCount en 1
        $sql = "UPDATE Questions SET CorrectCount = CorrectCount + 1 WHERE QuestionID = ?";

        // Preparar la consulta
        $stmt = $this->database->prepare($sql);

        // Verificar si la consulta se preparó correctamente
        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }

        // Vincular el parámetro de la consulta
        $stmt->bind_param("i", $questionID);

        // Ejecutar la consulta
        $result = $stmt->execute();

        // Cerrar la consulta y devolver el resultado
        $stmt->close();
        return $result;
    }

    public function getRandomQuestionByDifficulty() {
        // Generar una consulta SQL para obtener una pregunta aleatoria por dificultad
        $sql = "SELECT * FROM Questions ORDER BY IncorrectCount / (CorrectCount + IncorrectCount) ASC LIMIT 1";

        // Ejecutar la consulta en la base de datos
        $result = $this->database->query($sql);

        // Obtener la pregunta aleatoria por dificultad del resultado de la consulta
        $question = $result->fetch_assoc();

        // Devolver la pregunta
        return $question;
    }
    public function calculateQuestionDifficulty($questionID) {
        // Obtener los datos de la pregunta
        $question = $this->getQuestionById($questionID);
        $incorrectCount = $question['IncorrectCount'];
        $correctCount = $question['CorrectCount'];
    
        $aux =  $incorrectCount + $correctCount;
        if ($aux==0) {
            return "Fácil";
        }
         $difficulty= $correctCount / $aux;
    
        // Asignar una etiqueta de dificultad según el valor obtenido
        if ($difficulty < 3) {
            return "Fácil";
        } elseif ($difficulty < 7) {
            return "Normal";
        } else {
            return "Difícil";
        }
    }

    public function changeQuestionState($questionID, $stateID) {
        $sql = "UPDATE Questions SET StateID = ? WHERE QuestionID = ?";
        $stmt = $this->database->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ss", $stateID, $questionID);
        $success = $stmt->execute();
        $stmt->close();

        if ($success) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllQuestions() {
        $sql = "SELECT q.*, c.CategoryName, s.StateName
                FROM Questions q
                JOIN Categories c ON q.CategoryID = c.CategoryID
                JOIN States s ON q.StateID = s.StateID";
        $stmt = $this->database->prepare($sql);
    
        if (!$stmt) {
            return false;
        }
    
        $questions = [];
        $success = $stmt->execute();
    
        if (!$success) {
            return null;
        }
    
        $result = $stmt->get_result();
    
        if ($result->num_rows === 0) {
            // No se encontró ningún dato
            return null;
        }
    
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
    
        $stmt->close();
    
        return $questions;
    }

    public function createQuestion($questionText, $correctAnswer, $answer1, $answer2, $answer3, $categoryID,$StateID) {
        $sql = "INSERT INTO Questions (QuestionText, CorrectAnswer, Answer1, Answer2, Answer3, CategoryID, StateID) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->database->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("sssssss", $questionText, $correctAnswer, $answer1, $answer2, $answer3, $categoryID, $StateID);
        $success = $stmt->execute();
        $stmt->close();

        if ($success) {
            return true;
        } else {
            return false;
        }
    }
    public function updateQuestionState($questionID, $stateID)
    {
        $sql = "UPDATE Questions SET StateID = ? WHERE QuestionID = ?";
        $stmt = $this->database->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("ii", $stateID, $questionID);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function updateQuestion($questionID, $questionText, $correctAnswer, $answer1, $answer2, $answer3, $categoryID) {
        $sql = "UPDATE Questions SET QuestionText = ?, CorrectAnswer = ?, Answer1 = ?, Answer2 = ?, Answer3 = ?, CategoryID = ? 
                WHERE QuestionID = ?";
        $stmt = $this->database->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("sssssss", $questionText, $correctAnswer, $answer1, $answer2, $answer3, $categoryID, $questionID);
        $success = $stmt->execute();
        $stmt->close();

        if ($success) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteQuestion($questionID) {
        $sql = "DELETE FROM Questions WHERE QuestionID = ?";
        $stmt = $this->database->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $questionID);
        $success = $stmt->execute();
        $stmt->close();

        if ($success) {
            return true;
        } else {
            return false;
        }
    }

       public function getUsersCorrectAnswerPercentage($startDate, $endDate) {
        // Generar una consulta SQL para obtener el porcentaje de preguntas respondidas correctamente por usuario
        $sql = "SELECT u.UserID, u.FullName, COUNT(uq.UserQuestionID) AS TotalQuestions,
            SUM(q.CorrectCount) AS TotalCorrectAnswers,
            (SUM(q.CorrectCount) / COUNT(uq.UserQuestionID)) * 100 AS CorrectAnswerPercentage
            FROM User u
            LEFT JOIN UserQuestions uq ON u.UserID = uq.UserID
            LEFT JOIN Questions q ON uq.QuestionID = q.QuestionID
            INNER JOIN UserGames ug ON u.UserID = ug.UserID
            WHERE ug.Timestamp >= ? AND ug.Timestamp <= ?
            GROUP BY u.UserID";

        // Preparar la consulta
        $stmt = $this->database->prepare($sql);

        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
    
        // Obtener el resultado de la consulta
        $result = $stmt->get_result();
        // Obtener los resultados de la consulta
        $usersPercentage = array();
        $i=0;
        while ($row = $result->fetch_assoc()) {
            $userPercentage = array(
                'UserID' => $row['UserID'],
                'FullName' => $row['FullName'],
                'TotalQuestions' => $row['TotalQuestions'],
                'TotalCorrectAnswers' => $row['TotalCorrectAnswers'],
                'CorrectAnswerPercentage' => $row['CorrectAnswerPercentage']
            );
            $usersPercentage[] = $userPercentage;
            $charData["FullName"][$i] = $row['FullName'];
            $charData["CorrectAnswerPercentage"][$i] = $row['CorrectAnswerPercentage'];
            $i++;
        }
    
        // Devolver el porcentaje de preguntas respondidas correctamente por usuario
        return $charData;
    }

    public function getQuestionsCountByCategory() {
        // Generar una consulta SQL para obtener la cantidad de preguntas creadas por categoría
        $sql = "SELECT c.CategoryName,c.CategoryColor, COUNT(q.QuestionID) AS QuestionsCount
                FROM Categories c
                LEFT JOIN Questions q ON c.CategoryID = q.CategoryID
                GROUP BY c.CategoryID";
        
        // Preparar la consulta
        $stmt = $this->database->prepare($sql);
        
        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener el resultado de la consulta
        $result = $stmt->get_result();
        
        // Verificar si la consulta se ejecutó correctamente
        if (!$result) {
            // Error al ejecutar la consulta
            $stmt->close();
            return false;
        }
        
        // Obtener los datos de cantidad de preguntas por categoría
        $questionsCountByCategory = array();
            // Obtener el total de preguntas
        $totalQuestions = 0;
        while ($row = $result->fetch_assoc()) {
            $totalQuestions += $row['QuestionsCount'];
        }
        $result->data_seek(0); // Reiniciar el puntero del resultado
        $i=0;
        while ($row = $result->fetch_assoc()) {
            $categoryName = $row['CategoryName'];
            $questionsCount = $row['QuestionsCount'];
            $percentage = ($questionsCount / $totalQuestions) * 100;
            $questionsCountByCategory[] = array(
                "categoryName" => $categoryName,
                "questionsCount" => $questionsCount
            );
            $dataChart["categoryName"][$i]=$row['CategoryName'];
            $dataChart["percentage"][$i]=$percentage;
            $dataChart["CategoryColor"][$i]=$row['CategoryColor'];
            $i++;
        }

        // Cerrar la consulta
        $stmt->close();
        
        // Devolver la cantidad de preguntas por categoría
        return $dataChart;
    }

    public function getGamesCountByCreationDate($startDate, $endDate) {
        // Generar una consulta SQL para obtener la cantidad de partidas creadas por fecha de creación
        $sql = "SELECT DATE(Timestamp) AS GameDate, COUNT(GameID) AS GamesCount
                FROM UserGames
                WHERE Timestamp >= ? AND Timestamp <= ?
                GROUP BY DATE(Timestamp)";
        
        // Preparar la consulta
        $stmt = $this->database->prepare($sql);
        
        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }
        
        // Asignar los valores de los parámetros y ejecutar la consulta
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        
        // Obtener el resultado de la consulta
        $result = $stmt->get_result();
        
        // Verificar si la consulta se ejecutó correctamente
        if (!$result) {
            // Error al ejecutar la consulta
            $stmt->close();
            return false;
        }
        
        // Obtener los datos de cantidad de partidas por fecha de creación
        $gamesCountByCreationDate = array();
        $i=0;
        while ($row = $result->fetch_assoc()) {
            $gameDate = $row['GameDate'];
            $gamesCount = $row['GamesCount'];
            $chart['GameDate'][$i]=$row['GameDate'];
            $chart['GamesCount'][$i]=$row['GamesCount'];
            $gamesCountByCreationDate[] = array(
                "gameDate" => $gameDate,
                "gamesCount" => $gamesCount
            );
            $i++;
        }
        
        // Cerrar la consulta
        $stmt->close();
        
        // Devolver la cantidad de partidas por fecha de creación
        return $chart;
    }
    
}