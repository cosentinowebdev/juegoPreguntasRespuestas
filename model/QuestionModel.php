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
}