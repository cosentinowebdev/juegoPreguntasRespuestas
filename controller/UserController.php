<?php

class UserController {
    private $userModel;
    private $renderer;

    public function __construct($userModel, $renderer) {
        $this->userModel = $userModel;
        $this->renderer = $renderer;
    }

    public function createUser(){
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
