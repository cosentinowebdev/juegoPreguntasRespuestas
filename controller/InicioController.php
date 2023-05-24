<?php

class InicioController {
    private $songsModel;
    private $renderer;

    // public function __construct($songsModel, $renderer) {
    //     $this->songsModel = $songsModel;
    //     $this->renderer = $renderer;
    // }
    public function __construct($renderer) {
        $this->renderer = $renderer;
    }
    public function list() {
        // $data["canciones"] = $this->songsModel->getSongs();
        $data["estado"] = "true";
        $isLoggedIn = true;
        $this->renderer->render("inicio",['isLoggedIn' => $isLoggedIn]);
    }
}
