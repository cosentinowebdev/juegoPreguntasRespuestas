<?php

class UserController {
    private $userModel;
    private $renderer;

    public function __construct($userModel, $renderer) {
        $this->userModel = $userModel;
        $this->renderer = $renderer;
    }

    public function createUser(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                // Obtener los datos del formulario
                $fullName = $_POST['fullname'];
                $birthYear = $_POST['birthyear'];
                $gender = $_POST['gender'];
                $country = $_POST['country'];
                $city = $_POST['city'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $username = $_POST['username'];
                $accountStatus = 'active';
                $role = 'user';
                
                // Manejar el archivo cargado
                $targetDir = "imagen/";
                $originalFileName = $_FILES["profilepicture"]["name"];
                $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
                $newFileName = uniqid() . "." . $extension;
                $targetFile = $targetDir . $newFileName;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                
                // Verificar si el archivo es una imagen válida
                $check = getimagesize($_FILES["profilepicture"]["tmp_name"]);
                if ($check === false) {
                    $uploadOk = 0;
                }
                
                // Verificar la extensión del archivo
                if ($imageFileType !== 'jpg' && $imageFileType !== 'jpeg' && $imageFileType !== 'png') {
                    $uploadOk = 0;
                }
                
                // Verificar si el archivo ya existe
                if (file_exists($targetFile)) {
                    $uploadOk = 0;
                }
                
                // Verificar el tamaño máximo del archivo (opcional)
                if ($_FILES["profilepicture"]["size"] > 500000) {
                    $uploadOk = 0;
                }
                
                // Mover el archivo cargado a la carpeta "imagen" con el nuevo nombre
                if ($uploadOk == 1) {
                    move_uploaded_file($_FILES["profilepicture"]["tmp_name"], $targetFile);
                    $profilePicture = $targetFile;
                } else {
                    $profilePicture = "profile.jpg"; // Opcional: Puedes asignar un valor predeterminado en caso de que la carga de la imagen falle
                }
                
                // Crear una instancia del modelo de usuario
                
                // Llamar al método para registrar un nuevo usuario
                $this->userModel->registerUser($fullName, $birthYear, $gender, $country, $city, $email, $password, $username, $profilePicture, $accountStatus, $role);
                
                // Redireccionar al usuario a la página de inicio o a otra página deseada
                header('Location: index.php');
                exit();
            
        }else{
            // Iniciar la sesión si aún no está iniciada
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Verificar si el usuario está logeado
            $isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
            $data["isLoggedIn"]=$isLoggedIn;
            if ($isLoggedIn) {
                // El usuario ya está logeado

                // Redireccionar al usuario a la página de inicio
                $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
                // echo $baseUrl;
                // exit();
                header("Location: $baseUrl");
                exit();
                // $this->renderer->render("lobby_usuario",['dato' => true]);
            } else {
                // Mostrar la página de inicio de sesión
                $this->renderer->render("create_user", $data);
            }
        }

    }
    public function list() {
        $data["users"] = $this->userModel->getUser();
        $this->renderer->render("usuarios",$data);
    }
    public function lobby() {

            // Iniciar la sesión si aún no está iniciada
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Verificar si el usuario está logeado
            $isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
            $data["isLoggedIn"]=$isLoggedIn;
            if ($isLoggedIn) {
                // El usuario ya está logeado
                // Mostrar la página de inicio de sesión
                $this->renderer->render("lobby_usuario", $data);

                // $this->renderer->render("lobby_usuario",['dato' => true]);
            } else {

                // Redireccionar al usuario a la página de inicio
                $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
                // echo $baseUrl;
                // exit();
                header("Location: $baseUrl");
                exit();
            }
        
    }
}
