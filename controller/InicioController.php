<?php

class InicioController {
    private $renderer;
    private $session;

    public function __construct($renderer,$session) {
        $this->renderer = $renderer;
        $this->session = $session;
    }
    public function list() {
        // if (session_status() === PHP_SESSION_NONE) {
        //     session_start();
        // }
        // $isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
        // $data["isLoggedIn"]=$isLoggedIn;
        $data = $this->session->getData();
        $this->renderer->render("inicio",$data);
    }
}
