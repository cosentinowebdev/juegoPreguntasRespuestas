<?php

class LoginController {
    private $userModel;
    private $renderer;

    public function __construct($userModel, $renderer) {
        $this->userModel = $userModel;
        $this->renderer = $renderer;
    }
    public function list() {
        $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
        header("Location: $baseUrl");
        exit();
    }
    public function login() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username']; // Obtener el nombre de usuario del formulario
            $password = $_POST['password']; // Obtener la contraseña del formulario
            $autenticate = $this->authenticate($username, $password);

            // Autenticar las credenciales del usuario
            if ($autenticate['isLoggedIn']!=false) {
                $_SESSION['isLoggedIn'] = $autenticate['isLoggedIn'];
                $_SESSION['userId'] = $autenticate['user']['UserID'];
                $_SESSION['Rol']=$autenticate['user']['Rol'];
                // Redireccionar al usuario a la página de inicio
                $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
                $baseUrl=$baseUrl."user/lobby";
                header("Location: $baseUrl");
                exit();

            }elseif($autenticate['errorData'] || $autenticate['errorActivate']){

                $data['errorData']=$autenticate['errorData'];
                $data['errorActivate']=$autenticate['errorActivate'];
                $data['isLoggedIn']=$autenticate['isLoggedIn'];
                $this->renderer->render("login", $data);
            } else {
                // Las credenciales no son válidas
                $this->renderer->render("login", ['isLoggedIn' => false]);
            }
        } else {
            // Iniciar la sesión si aún no está iniciada
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Verificar si el usuario está logeado
            $isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
            $data['isLoggedIn']=$isLoggedIn;
            // var_dump($data);
            // echo("<br>");
            // exit();
            // var_dump($data);
            // exit();
            if ($isLoggedIn) {
                // El usuario ya está logeado

                // Redireccionar al usuario a la página de inicio
                $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
                $baseUrl=$baseUrl."user/lobby";
                // echo $baseUrl;
                // exit();
                header("Location: $baseUrl");
                exit();
                // $this->renderer->render("lobby_usuario",['dato' => true]);
            } else {
                // Mostrar la página de inicio de sesión
                $this->renderer->render("login", $data);
            }
        }
    }
    public function logout() {
        // Iniciar la sesión si aún no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Eliminar las variables de sesión relacionadas con el usuario
        unset($_SESSION['isLoggedIn']);
    
        // Destruir la sesión
        session_destroy();
    
        $baseUrl = dirname($_SERVER['SCRIPT_NAME']);

        header("Location: $baseUrl");
        exit();
    }
    public function authenticate($username, $password) {
        // Aquí debes realizar la lógica de autenticación con el modelo de usuario
        
        // Verificar si el nombre de usuario y la contraseña son correctos
        $credentials = $this->userModel->validateCredentials($username, $password);

        if ($credentials!=false && $credentials['AccountStatus'] == "Active") {
            // Iniciar la sesión si aún no está iniciada
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            // Establecer la variable de sesión para indicar que el usuario está logueado
            $data['isLoggedIn'] = true;
            // Establecer el ID del usuario en la sesión
            $data['user']=$credentials;
            $data['errorData'] = false;
            $data['errorActivate'] = false;
            return $data;

        } elseif($credentials!=false && $credentials['AccountStatus'] == "inactive"){
            $data['isLoggedIn'] = false;
            $data['errorActivate'] = true;
            $data['errorData'] = false;
            return $data;
        }else {
            // Las credenciales son incorrectas, mostrar la página de inicio de sesión nuevamente
            $data['isLoggedIn'] = false;
            $data['errorData'] = true;
            $data['errorActivate'] = false;
            return $data;
        }
    }
}
