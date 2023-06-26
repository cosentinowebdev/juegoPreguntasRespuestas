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
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();  

        
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
            if ($result2->num_rows > 0) {
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
    public function getAccountStatusPlayersCountDeprecado($status) {
        
        // Generar una consulta SQL para contar la cantidad de jugadores según el estado de la cuenta
        $sql = "SELECT COUNT(*) AS PlayersCount
                FROM User
                WHERE AccountStatus = ?";
    
        // Preparar la consulta
        $stmt = $this->database->prepare($sql);
    
        if (!$stmt) {
            // Error al preparar la consulta
            return false;
        }
    
        // Asignar el valor del parámetro y ejecutar la consulta
        $stmt->bind_param("s", $status);
        $stmt->execute();
    
        // Obtener el resultado de la consulta
        $result = $stmt->get_result();
    
        // Verificar si la consulta se ejecutó correctamente
        if (!$result) {
            // Error al ejecutar la consulta
            $stmt->close();
            return false;
        }
    
        // Obtener el número de jugadores según el estado de la cuenta
        $row = $result->fetch_assoc();
        $playersCount = $row['PlayersCount'];
    
        $stmt->close();
    
        // Devolver la cantidad de jugadores según el estado de la cuenta
        return $playersCount;
    }
    public function getAccountStatusPlayersCount($status, $startDate, $endDate) {
        // Generar una consulta SQL para contar la cantidad de jugadores según el estado de la cuenta y el rango de fechas
        $sql = "SELECT DATE_FORMAT(Timestamp, '%Y-%m-%d') AS Date, COUNT(*) AS PlayersCount
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
    
        // Obtener los datos de fecha y cantidad de jugadores
        $playersData = array();
        $i=0;
        while ($row = $result->fetch_assoc()) {
            $date = $row['Date'];
            $playersCount = $row['PlayersCount'];
            $playersData['playersCount'][$i] = $playersCount;
            $playersData['date'][$i] = $date;
            $i++;
        }
        $stmt->close();
    
        // Devolver los datos de fecha y cantidad de jugadores
        return $playersData;
    }

    public function getUsersCountByAgeGroup($startDate, $endDate) {
        // Obtener el año actual
        $currentYear = date("Y");
    
        // Definir los rangos de edad para cada grupo
        $ageGroups = array(
            "menores" => array("minAge" => 0, "maxAge" => 17),
            "jubilados" => array("minAge" => 65, "maxAge" => 150),
            "adulto" => array("minAge" => 18, "maxAge" => 64)
        );
    
        // Inicializar el contador de usuarios por grupo de edad
        $usersCountByAgeGroup = array(
            "menores" => 0,
            "jubilados" => 0,
            "adulto" => 0
        );
    
        // Recorrer los grupos de edad y realizar la consulta por cada uno
        foreach ($ageGroups as $ageGroup => $ageRange) {
            // Calcular el año de nacimiento límite inferior y superior según el rango de edad
            $minBirthYear = $currentYear - $ageRange["maxAge"] - 1;
            $maxBirthYear = $currentYear - $ageRange["minAge"];
    
            // Generar una consulta SQL para contar la cantidad de usuarios según el grupo de edad
            $sql = "SELECT COUNT(DISTINCT User.UserID) AS UsersCount
            FROM User
            INNER JOIN UserGames ON User.UserID = UserGames.UserID
            WHERE User.BirthYear >= ? AND User.BirthYear <= ?
            AND UserGames.Timestamp >= ? AND UserGames.Timestamp <= ?";
    
            // Preparar la consulta
            $stmt = $this->database->prepare($sql);
    
            if (!$stmt) {
                // Error al preparar la consulta
                return false;
            }
    
            // Asignar los valores de los parámetros y ejecutar la consulta
            $stmt->bind_param("iiss", $minBirthYear, $maxBirthYear, $startDate, $endDate);
            $stmt->execute();
    
            // Obtener el resultado de la consulta
            $result = $stmt->get_result();
    
            // Verificar si la consulta se ejecutó correctamente
            if (!$result) {
                // Error al ejecutar la consulta
                $stmt->close();
                return false;
            }
    
            // Obtener el número de usuarios según el grupo de edad
            $row = $result->fetch_assoc();

            $usersCount = $row['UsersCount'];
    
            $stmt->close();
    
            // Actualizar el contador de usuarios por grupo de edad
            $usersCountByAgeGroup[$ageGroup] = $usersCount;
        }
    
        // Crear el texto descriptivo para cada grupo de edad
        $descriptiveTexts = array(
            "menores" => "menores de edad",
            "jubilados" => "jubilados",
            "adulto" => "adultos"
        );
    
        // Crear un array que contenga la cantidad de usuarios y el texto descriptivo para cada grupo de edad
        $usersByAgeGroup = array();
        $i=0;
        foreach ($usersCountByAgeGroup as $ageGroup => $count) {
            // Obtener las edades correspondientes para cada grupo de edad
            $minAge = $ageGroups[$ageGroup]["minAge"];
            $maxAge = $ageGroups[$ageGroup]["maxAge"];
    
            // Crear el texto descriptivo con las edades
            $descriptiveText = $count . " " . $descriptiveTexts[$ageGroup] . " (edad: " . $minAge . "-" . $maxAge . ")";
            $charData["ageGroup"][$i] = $descriptiveTexts[$ageGroup];
            $charData["count"][$i] = $count;
            $usersByAgeGroup[] = array(
                "group" => $ageGroup,
                "count" => $count,
                "descriptiveText" => $descriptiveText
            );
            $i++;
        }
    
        // Devolver el array con la cantidad de usuarios por grupo de edad y el texto descriptivo
        return $charData;
    }
    public function getUsersCountByGender($startDate, $endDate) {
        // Generar una consulta SQL para contar la cantidad de usuarios por sexo
        $sql = "SELECT Gender, COUNT(DISTINCT User.UserID) AS UsersCount
                FROM User
                INNER JOIN UserGames ON User.UserID = UserGames.UserID
                WHERE UserGames.Timestamp >= ? AND UserGames.Timestamp <= ?
                GROUP BY Gender";

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

        // Verificar si la consulta se ejecutó correctamente
        if (!$result) {
            // Error al ejecutar la consulta
            $stmt->close();
            return false;
        }
    
        // Obtener los resultados de la consulta
        $usersCountByGender = array();
        $i=0;
        while ($row = $result->fetch_assoc()) {
            $gender = $row['Gender'];
            $usersCount = $row['UsersCount'];
            $charData['Gender'][$i]=$row['Gender'];
            $charData['UsersCount'][$i]=$row['UsersCount'];
            // $usersCountByGender[$gender] = $usersCount;
            $i++;
        }
    
        // Devolver la cantidad de usuarios por sexo
        return $charData;
    }
    public function getUsersCountByCountry($startDate, $endDate) {
        // Generar una consulta SQL para contar la cantidad de usuarios por país
        $sql = "SELECT Country, COUNT(DISTINCT User.UserID) AS UsersCount
                FROM User
                INNER JOIN UserGames ON User.UserID = UserGames.UserID
                WHERE UserGames.Timestamp >= ? AND UserGames.Timestamp <= ?
                GROUP BY Country";

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

        // Verificar si la consulta se ejecutó correctamente
        if (!$result) {
            // Error al ejecutar la consulta
            $stmt->close();
            return false;
        }
    
        // Obtener los resultados de la consulta
        $usersCountByCountry = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            // $country = $row['Country'];
            // $usersCount = $row['UsersCount'];
            // $usersCountByCountry[$country] = $usersCount;
            $charData['Country'][$i]=$row['Country'];
            $charData['UsersCount'][$i]=$row['UsersCount'];

            $i++;
        }

        // Devolver la cantidad de usuarios por país
        return $charData;
    }
}