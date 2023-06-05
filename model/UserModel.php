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
    public function getUserById($userId) {
        $sql = "SELECT * FROM User WHERE UserID = :userId";
        $params = array(':userId' => $userId);
        $result = $this->database->query($sql, $params);

        if (!empty($result)) {
            return $result[0];
        } else {
            return null;
        }
    }
    public function validateCredentials($username, $password) {
        $query = "SELECT * FROM User WHERE Username = ?";
        $stmt = $this->database->prepare($query);
        // Asignar el valor del nombre de usuario al marcador de posición
        $stmt->bind_param("s", $username);
        // Ejecutar la consulta preparada
        $stmt->execute();
        if (!$stmt->execute()) {
            echo "<br><p>Error al ejecutar la consulta: " . $stmt->error."</p></p>";
            return false;
        }else{

        }
        // Obtener el resultado de la consulta
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {

            $row = $result->fetch_assoc();
            $storedPassword = $row['Password'];
            $userId = $row['UserID'];
            
            // Verificar la contraseña
            // if (password_verify($password, $storedPassword)) {
            //     return true; // Las credenciales son válidas
            // }
            if ($password===$storedPassword) {
                return $userId;
            }
        }

        return false; // Las credenciales no son válidas
    }
    public function validateRol() {
        // Verificar si la cookie existe
        if (isset($_COOKIE['isLoggedIn'])) {
            // Obtener el valor de la cookie
            $cookieValue = $_COOKIE['isLoggedIn'];

            // Separar el ID del usuario del valor de la cookie
            $parts = explode('_', $cookieValue);
            $loggedInUserId = $parts[1];

            // Ahora tienes el ID del usuario que corresponde a la cookie
            echo "La cookie pertenece al usuario con ID $loggedInUserId.";
            $query = "SELECT * FROM User WHERE UserID = ?";
            $stmt = $this->database->prepare($query);
            // Asignar el valor del nombre de usuario al marcador de posición
            $stmt->bind_param("s", $loggedInUserId);
            // Ejecutar la consulta preparada
            $stmt->execute();
            $result = $stmt->get_result();
            var_dump($result);
            exit();
        } 
    }
    public function registerUser($fullName, $birthYear, $gender, $country, $city, $email, $password, $username, $profilePicture, $accountStatus, $role) {
        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hashing the password
    
        // Preparar la consulta SQL para insertar un nuevo usuario en la base de datos
        $query = "INSERT INTO User (FullName, BirthYear, Gender, Country, City, Email, Password, Username, ProfilePicture, AccountStatus, Rol)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("sisssssssss", $fullName, $birthYear, $gender, $country, $city, $email, $password, $username, $profilePicture, $accountStatus, $role);
        
        if ($stmt->execute()) {
            return true; // Registro exitoso
        } else {
            return false; // Error al registrar el usuario
        }
    }
    public function checkUserExistence($username, $email) {
        $query = "SELECT * FROM User WHERE Username = ?";
        $stmt = $this->database->prepare($query);
        // $stmt->bind_param("ss", $username, $email);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();  
        // echo($username);
        // var_dump($result->num_rows);     
        // echo($result->num_rows > 0);
        
        if ($result->num_rows > 0) {
            // exit();
            return true; // El usuario  ya existe
        } else {
            $query = "SELECT * FROM User WHERE Email = ?";
            $stmt = $this->database->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result2 = $stmt->get_result();
            $stmt->close();
            // var_dump($result2->num_rows);
            if ($result2->num_rows > 0) {
                // exit();
                return true; // El correo ya existe
            } else {
                return false; // El usuario o correo electrónico no existe
            }
        }
    }
    public function activateUser($userID) {
        $query = "UPDATE User SET AccountStatus = 'active' WHERE UserID = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $userID);
        // $stmt->execute();
        if ($stmt->execute()) {
            $stmt->close();
            return true; // Registro exitoso
        } else {
            return false; // Error al registrar el usuario
        }
        
    }
}