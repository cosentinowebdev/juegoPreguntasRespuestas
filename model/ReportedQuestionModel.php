<?php

class ReportedQuestionModel {

    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function createReportedQuestion($questionID, $userID, $reportReason) {
        // Definir el estado inicial del reporte
        $status = 'pending';
    
        // Generar una consulta SQL para insertar el nuevo reporte en la tabla ReportedQuestion
        $sql = "INSERT INTO ReportedQuestion (QuestionID, UserID, ReportReason, Status)
                VALUES (?, ?, ?, ?)";
    
        // Preparar la consulta
        $stmt = $this->database->prepare($sql);
    
        // Verificar si la consulta se preparó correctamente
        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }
    
        // Vincular los parámetros de la consulta
        $stmt->bind_param("iiss", $questionID, $userID, $reportReason, $status);
    
        // Ejecutar la consulta
        $result = $stmt->execute();
    
        // Verificar si la consulta se ejecutó correctamente
        if (!$result) {
            // Error al ejecutar la consulta
            return false;
        }
    
        // Cerrar la consulta y devolver el resultado
        $stmt->close();
        return true;
    }

    public function listReportedQuestions() {
        // Generar una consulta SQL para obtener las preguntas reportadas con las relaciones
        $sql = "SELECT R.*, Q.QuestionText, Q.CorrectAnswer, Q.Answer1, Q.Answer2, Q.Answer3, C.CategoryName, S.StateName, U.FullName, U.UserID
                FROM ReportedQuestion R
                INNER JOIN Questions Q ON R.QuestionID = Q.QuestionID
                INNER JOIN User U ON R.UserID = U.UserID
                INNER JOIN Categories C ON Q.CategoryID = C.CategoryID
                INNER JOIN States S ON Q.StateID = S.StateID";
        
        $stmt = $this->database->prepare($sql);
    
        if (!$stmt) {
            return false;
        }
    
        $reportedQuestions = [];
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
            $reportedQuestions[] = $row;
        }
    
        $stmt->close();
    
        return $reportedQuestions;
    }

    public function readReportedQuestion($reportID) {
        // Generar una consulta SQL para obtener los datos de una pregunta reportada con relaciones
        $sql = "SELECT R.*, Q.QuestionText, Q.CorrectAnswer, Q.Answer1, Q.Answer2, Q.Answer3, C.CategoryName, U.FullName
                FROM ReportedQuestion R
                INNER JOIN Questions Q ON R.QuestionID = Q.QuestionID
                INNER JOIN User U ON R.UserID = U.UserID
                INNER JOIN Categories C ON Q.CategoryID = C.CategoryID
                WHERE R.ReportID = ?";
        
        // Preparar la consulta
        $stmt = $this->database->prepare($sql);
        
        // Verificar si la consulta se preparó correctamente
        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }
        
        // Vincular el parámetro de la consulta
        $stmt->bind_param("i", $reportID);
        
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener el resultado de la consulta
        $result = $stmt->get_result();
        
        // Verificar si se obtuvo algún resultado
        if ($result->num_rows === 0) {
            // No se encontró la pregunta reportada
            return null;
        }
        
        // Obtener los datos de la pregunta reportada con relaciones
        $reportedQuestion = $result->fetch_assoc();
        
        // Cerrar la consulta y devolver los datos de la pregunta reportada con relaciones
        $stmt->close();
        return $reportedQuestion;
    }

    public function deleteReportedQuestion($reportID) {
        // Generar una consulta SQL para eliminar una pregunta reportada
        $sql = "DELETE FROM ReportedQuestion WHERE ReportID = ?";
        
        // Preparar la consulta
        $stmt = $this->database->prepare($sql);
        
        // Verificar si la consulta se preparó correctamente
        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }
        
        // Vincular el parámetro de la consulta
        $stmt->bind_param("i", $reportID);
        
        // Ejecutar la consulta
        $result = $stmt->execute();
        
        // Verificar si la consulta se ejecutó correctamente
        if (!$result) {
            // Error al ejecutar la consulta
            return false;
        }
        
        // Cerrar la consulta y devolver el resultado
        $stmt->close();
        return true;
    }

    public function updateReportedQuestion($reportID, $status) {
        // Generar una consulta SQL para actualizar el estado de la pregunta reportada
        $sql = "UPDATE ReportedQuestion SET Status = ? WHERE ReportID = ?";
        
        // Preparar la consulta
        $stmt = $this->database->prepare($sql);
        
        // Verificar si la consulta se preparó correctamente
        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }
        
        // Vincular los parámetros de la consulta
        $stmt->bind_param("si", $status, $reportID);
        
        // Ejecutar la consulta
        $result = $stmt->execute();
        
        // Verificar si la consulta se ejecutó correctamente
        if (!$result) {
            // Error al ejecutar la consulta
            return false;
        }
        
        // Cerrar la consulta y devolver el resultado
        $stmt->close();
        return true;
    }
}