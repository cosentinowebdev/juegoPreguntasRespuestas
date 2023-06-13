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
        $loggedInUserId = isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
        $gameId = isset($_SESSION['gameId']) ? $_SESSION['gameId'] : null;
        $data["isLoggedIn"]=$isLoggedIn;
        if ($isLoggedIn) {
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $QuestionID = $_POST['id'];
                $questionPrevious = $this->questionModel->getQuestionById($QuestionID);
                if ($questionPrevious["CorrectAnswer"]==$_POST["answer"]) {
                    $data["userGame"]=$this->gameModel->updateScoreAndNumQuestions($gameId,1,1,'incomplete');
                    $this->questionModel->incrementCorrectCount($QuestionID);
                } else {
                    $data["userGame"]=$this->gameModel->updateScoreAndNumQuestions($gameId,0,1,'finish');
                    $data["isFinishResult"]=true;
                    if (isset($_SESSION['gameId'])) {
                        unset($_SESSION['gameId']);
                    }
                    $this->questionModel->incrementIncorrectCount($QuestionID);
                }           
            }else{
                $UserGame = $this->gameModel->initGame($loggedInUserId);
                $_SESSION['gameId'] = $UserGame['GameID'];
                $data["userGame"] = $UserGame;
            }
            $data["question"]=$this->questionModel->getRandomQuestion();
            $data["questionAnswers"]=[$data["question"]["CorrectAnswer"],$data["question"]["Answer1"],$data["question"]["Answer2"],$data["question"]["Answer3"]];
            shuffle($data["questionAnswers"]);

            $this->renderer->render("play",$data);
        } else {
            $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
            header("Location: $baseUrl");
            exit();
        }
        
        
    }

}
