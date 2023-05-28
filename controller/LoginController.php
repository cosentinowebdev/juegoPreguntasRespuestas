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
        // $data["users"] = $this->userModel->getUser();
        // $this->renderer->render("usuarios",$data);
        // Redireccionar al usuario a la página de inicio
        $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
        // echo $baseUrl;
        // exit();
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
                // Las credenciales son válidas
                // $hash = md5(time());
                // $archivo = 'seguridad.txt';
                // if (!file_exists($archivo)) {
                //     $contenido = ''; // Puedes definir un contenido inicial si lo deseas
                //     file_put_contents($archivo, $contenido);
                // }
                // $content = $hash . ':' . $autenticate['user'];
                // file_put_contents($archivo, $content);
                // Establecer la cookie
                $cookieName = 'isLoggedIn';
                // $cookieValue = $hash;
                $cookieValue = $autenticate['isLoggedIn'];
                $cookieExpiration = time() + 3600; // Expire en 1 hora
                setcookie($cookieName, $cookieValue, $cookieExpiration, '/');

                // Redireccionar al usuario a la página de inicio
                $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
                $baseUrl=$baseUrl."user/lobby";
                // echo $baseUrl;
                // exit();
                header("Location: $baseUrl");
                exit();
                // $this->renderer->render("lobby_usuario",['falopa' => true]);

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

        if ($credentials!=false) {
            // Iniciar la sesión si aún no está iniciada
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            // Establecer la variable de sesión para indicar que el usuario está logueado
            $data['isLoggedIn'] = true;
            $_SESSION['isLoggedIn'] = true;
            $data['user']=$credentials;
            return $data;

        } else {
            // Las credenciales son incorrectas, mostrar la página de inicio de sesión nuevamente
            $data['isLoggedIn'] = false;

            return $data;
        }
    }
}
