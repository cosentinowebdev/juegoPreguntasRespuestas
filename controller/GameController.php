<?php

class GameController {
    private $gameModel;
    private $questionModel;
    private $renderer;

    public function __construct($gameModel,$questionModel, $renderer) {
        $this->gameModel = $gameModel;
        $this->questionModel = $questionModel;
        $this->renderer = $renderer;
    }
    public function play() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
        $data["isLoggedIn"]=$isLoggedIn;
        if ($isLoggedIn) {
            $this->renderer->render("play",$data);
        } else {
            $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
            header("Location: $baseUrl");
            exit();
        }
        
        
    }

}
