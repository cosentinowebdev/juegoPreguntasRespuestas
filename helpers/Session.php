<?php

/**
 * clase de manejo de sesiones
 */
class Session{
    private $data;
    public function __construct(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
        $Rol = isset($_SESSION['Rol']) ? $_SESSION['Rol'] : null;
        $this->data["isLoggedIn"]=$isLoggedIn;
        $this->data["isEditor"] = ($Rol === 'editor');
        $this->data["isAdmin"] = ($Rol === 'admin');
        $this->data["isUser"] = ($Rol === 'user');
    }
    public function getData(){
        return $this->data;
    }
}