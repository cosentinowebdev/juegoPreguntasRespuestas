<?php

class LoginController {
    private $userModel;
    private $renderer;

    public function __construct($userModel, $renderer) {
        $this->userModel = $userModel;
        $this->renderer = $renderer;
    }
    // public function __construct($renderer) {
    //     $this->renderer = $renderer;
    // }
    public function list() {
        $data["users"] = $this->userModel->getUser();
        $this->renderer->render("usuarios",$data);
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username']; // Obtener el nombre de usuario del formulario
            $password = $_POST['password']; // Obtener la contraseña del formulario

            $this->authenticate($username, $password);
        } else {
                // Iniciar la sesión si aún no está iniciada
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Verificar si el usuario está logeado
            $isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
            if ($isLoggedIn) {
                // $this->renderer->render("inicio",['isLoggedIn' => $isLoggedIn]);
                header('Location: '."index.php");
                exit();
            } else {
                $this->renderer->render("login",['isLoggedIn' => $isLoggedIn]);
            }
        }
    }
    public function authenticate($username, $password) {
        // Aquí debes realizar la lógica de autenticación con el modelo de usuario
        
        // Verificar si el nombre de usuario y la contraseña son correctos
        $isValidCredentials = $this->userModel->validateCredentials($username, $password);
        if ($isValidCredentials) {
            // Iniciar la sesión si aún no está iniciada
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
    
            // Establecer la variable de sesión para indicar que el usuario está logueado
            $_SESSION['isLoggedIn'] = true;
    
            // Redirigir al usuario a una página diferente después de iniciar sesión exitosamente
            // header('Location: index.php'); // Cambia "index.php" por la URL de la página a la que deseas redirigir al usuario
            exit("funco");
        } else {
            // Las credenciales son incorrectas, mostrar la página de inicio de sesión nuevamente
            $isLoggedIn = false;
            // exit("error");
            $this->renderer->render("login", ['isLoggedIn' => $isLoggedIn]);
        }
    }
}
