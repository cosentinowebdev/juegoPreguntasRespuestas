<?php

class InicioController {
    private $renderer;

    public function __construct($renderer) {
        $this->renderer = $renderer;
    }
    public function list() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
        $data["isLoggedIn"]=$isLoggedIn;
        $this->renderer->render("inicio",$data);
    }
}
