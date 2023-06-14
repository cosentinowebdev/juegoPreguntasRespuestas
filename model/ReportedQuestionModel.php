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
}