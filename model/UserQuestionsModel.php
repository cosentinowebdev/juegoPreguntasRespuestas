<?php

class UserQuestionModel {

    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function createUserQuestion($userID, $questionID, $gameID,$time) {
        $sql = "INSERT INTO UserQuestions (UserID, QuestionID, GameID, time)
                VALUES (?, ?, ?, ?)";
        
        $stmt = $this->database->prepare($sql);
        
        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }
        
        $stmt->bind_param("iiii", $userID, $questionID, $gameID, $time);
        $stmt->execute();
        
        if ($stmt->affected_rows === 0) {
            // No se pudo insertar la fila
            $stmt->close();
            return false;
        }
        
        $stmt->close();
        
        return true;
    }

    public function getUserQuestion($userQuestionID) {
        $sql = "SELECT * FROM UserQuestions WHERE UserQuestionID = ?";
        
        $stmt = $this->database->prepare($sql);
        
        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }
        
        $stmt->bind_param("i", $userQuestionID);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if (!$result) {
            // Error al ejecutar la consulta
            $stmt->close();
            return false;
        }
        
        $userQuestion = $result->fetch_assoc();
        
        $stmt->close();
        
        return $userQuestion;
    }
    public function updateUserQuestion($userQuestionID, $userID, $questionID, $gameID) {
        $sql = "UPDATE UserQuestions SET UserID = ?, QuestionID = ?, GameID = ? WHERE UserQuestionID = ?";
        
        $stmt = $this->database->prepare($sql);
        
        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }
        
        $stmt->bind_param("iiii", $userID, $questionID, $gameID, $userQuestionID);
        $stmt->execute();
        
        if ($stmt->affected_rows === 0) {
            // No se pudo actualizar la fila
            $stmt->close();
            return false;
        }
        
        $stmt->close();
        
        return true;
    }
    public function deleteUserQuestion($userQuestionID) {
        $sql = "DELETE FROM UserQuestions WHERE UserQuestionID = ?";
        
        $stmt = $this->database->prepare($sql);
        
        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }
        
        $stmt->bind_param("i", $userQuestionID);
        $stmt->execute();
        
        if ($stmt->affected_rows === 0) {
            // No se pudo eliminar la fila
            $stmt->close();
            return false;
        }
        
        $stmt->close();
        
        return true;
    }
    
    public function getLastUserQuestion($userId) {
        $sql = "SELECT *
                FROM UserQuestions
                WHERE UserID = ?
                ORDER BY UserQuestionID DESC
                LIMIT 1";
        
        $stmt = $this->database->prepare($sql);
        $stmt->bind_param("i", $userId);
        
        if (!$stmt->execute()) {
            return null;
        }
        
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return null;
        }
        
        $userQuestion = $result->fetch_assoc();
        return $userQuestion;
    }

}