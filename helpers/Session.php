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
        $gameId = isset($_SESSION['gameId']) ? $_SESSION['gameId'] : null;
        $isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
        $loggedInUserId = isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
        $Rol = isset($_SESSION['Rol']) ? $_SESSION['Rol'] : null;
        $this->data["userId"] = $loggedInUserId;
        $this->data["isLoggedIn"] = $isLoggedIn;
        $this->data["isEditor"] = ($Rol === 'editor');
        $this->data["isAdmin"] = ($Rol === 'admin');
        $this->data["isUser"] = ($Rol === 'user');
        $this->data["gameId"] = $gameId;
    }
    public function getData(){
        return $this->data;
    }
}