<?php
require_once 'helpers/qr/qrlib.php';
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
        $sql = "SELECT * FROM User WHERE UserID = ?";
        $stmt = $this->database->prepare($sql);
        
        if (!$stmt) {
            // Error al preparar la consulta
            return null;
        }
        
        $stmt->bind_param("s", $userId);
        
        if (!$stmt->execute()) {
            // Error al ejecutar la consulta
            return null;
        }
        
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            // No se encontró ningún usuario con el ID proporcionado
            return null;
        }
        
        $user = $result->fetch_assoc();
        return $user;
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
                return $row;
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
            $userId = $stmt->insert_id;
            $qrCodeContent = "http://localhost/user/showUser?id=1${$userId}"; // URL a la que se redirigirá al escanear el código QR
            $tempImagePath = 'temp_qrcode.png';
            
            QRcode::png($qrCodeContent, $tempImagePath, QR_ECLEVEL_L, 10);
            $imageData = file_get_contents($tempImagePath);
            // Codificar la imagen en base64
            $qrCodeBase64 = base64_encode($imageData);
            $this->saveQrCode($userId,$qrCodeBase64);
            unlink($tempImagePath);
            return true; // Registro exitoso
        } else {
            return false; // Error al registrar el usuario
        }
    }
    public function saveQrCode($userId, $qrCodeBase64) {
        // Preparar la consulta SQL para actualizar el registro del usuario con el código QR en base64
        $query = "UPDATE User SET QrPicture = ? WHERE UserId = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("si", $qrCodeBase64, $userId);
        
        // Ejecutar la consulta
        return $stmt->execute();
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

    public function getUsersRankedByScore() {
        // Generar una consulta SQL para obtener el puntaje total y el total de partidas ganadas agrupados por usuario
        $sql = "SELECT u.UserID, u.FullName, u.Username, SUM(ug.Score) AS TotalScore, COUNT(CASE WHEN ug.Result = 'finish' THEN 1 END) AS TotalWins
                FROM User u
                INNER JOIN UserGames ug ON u.UserID = ug.UserID
                GROUP BY u.UserID
                ORDER BY TotalScore DESC";

        // Ejecutar la consulta en la base de datos
        $result = $this->database->query($sql);

        // Verificar si la consulta se ejecutó correctamente
        if (!$result) {
            // Error al ejecutar la consulta
            return false;
        }

        // // Obtener los usuarios clasificados por puntaje con sus datos
        // $users = array();
        // while ($row = $result->fetch_assoc()) {
        //     $users[] = $row;
        // }

        // Devolver los usuarios clasificados por puntaje
        return $result;
    }
}