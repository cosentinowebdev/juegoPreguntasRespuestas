<?php

class UserModel {

    private $database;

    public function __construct($database) {
        $this->database = $database;
    }
    // public function __construct() {
        
    // }

    public function getUser() {
        return $this->database->query('SELECT * FROM User');
    }
    public function validateCredentials($username, $password) {
        $query = "SELECT * FROM User WHERE Username = ?";
        $stmt = $this->database->prepare($query);
        // Asignar el valor del nombre de usuario al marcador de posición
        $stmt->bind_param("s", $username);
        // Ejecutar la consulta preparada
        $stmt->execute();
        if (!$stmt->execute()) {
            echo "Error al ejecutar la consulta: " . $stmt->error;
            return false;
        }else{
            echo(" no hay error");
        }
        // Obtener el resultado de la consulta
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            echo(" no hay error");
            $row = $result->fetch_assoc();
            $storedPassword = $row['Password'];
    
            // Verificar la contraseña
            // if (password_verify($password, $storedPassword)) {
            //     return true; // Las credenciales son válidas
            // }
            if ($password===$storedPassword) {
                return true;
            }
        }
        echo(" no hay error");
        return false; // Las credenciales no son válidas
    }
}