<?php

class InicioController {
    private $renderer;
    private $session;

    public function __construct($renderer,$session) {
        $this->renderer = $renderer;
        $this->session = $session;
    }
    public function list() {
        $data = $this->session->getData();
        $this->renderer->render("inicio",$data);
    }
}
