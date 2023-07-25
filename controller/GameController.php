<?php

class GameController {
    private $gameModel;
    private $questionModel;
    private $renderer;
    private $ReportedQuestionModel;
    private $session;
    private $UserQuestionModel;

    public function __construct(
        $gameModel,
        $questionModel,
        $ReportedQuestionModel,
        $UserQuestionModel,
        $renderer,
        $session,
        $userModel) {
        $this->gameModel = $gameModel;
        $this->questionModel = $questionModel;
        $this->renderer = $renderer;
        $this->ReportedQuestionModel = $ReportedQuestionModel;
        $this->UserQuestionModel = $UserQuestionModel;
        $this->session = $session;
        $this->userModel = $userModel;
    }
    public function list(){
        $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
        $baseUrl=$baseUrl."game/play";
        header("Location: $baseUrl ");
        exit();
    }
    public function play() {
        $data = $this->session->getData();
        $loggedInUserId = $data["userId"];
        $gameId = $data["gameId"];
        $QuestionID="";
        $finisGame = false;
        $user = $this->userModel->getUserRankedByScore($loggedInUserId);
        $data["userData"]=$user;
        $data["time"]=10;
        $time = 10;
        if ($data["isLoggedIn"]) {
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $QuestionID = $_POST['id'];
                $questionPrevious = $this->questionModel->getQuestionById($QuestionID);
                $lastUserQuestion = $this->UserQuestionModel->getLastUserQuestion($loggedInUserId);

                // Obtener la hora actual
                $currentTime = new DateTime();

                // Convertir el valor del campo 'timestamp' a un objeto DateTime
                $timestampValue = new DateTime($lastUserQuestion["timestamp"]);

                // Calcular la diferencia entre la hora actual y el valor del campo 'timestamp'
                $timeDifference = $currentTime->diff($timestampValue);

                // Obtener el valor del campo 'time'
                $timeValue = $lastUserQuestion["time"];

                // Comparar la diferencia con el valor del campo 'time'
                //pasa el tiempo de juego backend
                if (!($timeDifference->s <= $timeValue && $timeDifference->i == 0 )) {
                   // La diferencia es mayor al valor del campo 'time'
                    // si trae distinta QuestionID se cae el juego
                    $data["userGame"]=$this->gameModel->updateScoreAndNumQuestions($gameId,0,1,'finish');
                    $data["isFinishResult"]=true;
                    $data["tiempo"]=true;
                    if (isset($_SESSION['gameId'])) {
                        unset($_SESSION['gameId']);
                    }
                    $finisGame = $this->questionModel->incrementIncorrectCount($QuestionID);
                    if(!$data["userGame"]){
                        $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
                        header("Location: $baseUrl");
                        exit();
                    }
                } else if (isset($_POST['userResponse']) && $_POST['userResponse'] === false) {
                     //pasa el tiempo de juego frontend
                    $data["userGame"]=$this->gameModel->updateScoreAndNumQuestions($gameId,0,1,'finish');
                    $data["isFinishResult"]=true;
                    if (isset($_SESSION['gameId'])) {
                        unset($_SESSION['gameId']);
                    }
                    $finisGame = $this->questionModel->incrementIncorrectCount($QuestionID);
                }else if ($QuestionID == $lastUserQuestion["QuestionID"] && !isset($_POST['userReplay'])) {
                    $this->questionModel->changeQuestionDifficulty($lastUserQuestion["QuestionID"]);
                    if ($questionPrevious["CorrectAnswer"]==$_POST["answer"]) {
                        $data["userGame"]=$this->gameModel->updateScoreAndNumQuestions($gameId,1,1,'incomplete');
                        $this->questionModel->incrementCorrectCount($QuestionID);
                    } else {
                        $data["userGame"]=$this->gameModel->updateScoreAndNumQuestions($gameId,0,1,'finish');
                        $data["isFinishResult"]=true;
                        if (isset($_SESSION['gameId'])) {
                            unset($_SESSION['gameId']);
                        }
                        $finisGame = $this->questionModel->incrementIncorrectCount($QuestionID);
                    }   
                }else if(isset($_POST['userReplay'])){
                    $UserGame = $this->gameModel->initGame($loggedInUserId);
                    $_SESSION['gameId'] = $UserGame['GameID'];
                    $gameId = $UserGame['GameID'];
                    $data["userGame"] = $UserGame;
                }else{
                    // si trae distinta QuestionID se cae el juego
                    $data["userGame"]=$this->gameModel->updateScoreAndNumQuestions($gameId,0,1,'finish');
                    $data["isFinishResult"]=true;
                    $data["cheat"]=true;
                    if (isset($_SESSION['gameId'])) {
                        unset($_SESSION['gameId']);
                    }
                    $finisGame = $this->questionModel->incrementIncorrectCount($QuestionID);
                    if(!$data["userGame"]){
                        $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
                        header("Location: $baseUrl");
                        exit();
                    }
                }
            }else{
                $UserGame = $this->gameModel->initGame($loggedInUserId);
                $_SESSION['gameId'] = $UserGame['GameID'];
                $gameId = $UserGame['GameID'];
                $data["userGame"] = $UserGame;
            }

            $data["question"]=$this->questionModel->getUnselectedQuestionDifficulty($loggedInUserId,$user[0]["nivel"]);
            $QuestionID=$data["question"]["QuestionID"];
            $data["questionAnswers"]=[$data["question"]["CorrectAnswer"],$data["question"]["Answer1"],$data["question"]["Answer2"],$data["question"]["Answer3"]];
            if(!$finisGame){
                $userQuestionCreate=$this->UserQuestionModel->createUserQuestion($loggedInUserId,$QuestionID,$gameId,$time);
            }
            shuffle($data["questionAnswers"]);
            if($data["question"]["Difficulty"]!=$user[0]["nivel"]){
                $data["dificultyDiference"]=true;
            }

            $this->renderer->render("play",$data);
        } else {
            $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
            header("Location: $baseUrl");
            exit();
        }
    }

    public function reportQuestion()
    {
        $data = $this->session->getData();
        $loggedInUserId = $data["userId"];
        $gameId = $data["gameId"];
        
        if ($data["isLoggedIn"] && $gameId) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (!isset($_GET['id'])) {
                    $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
                    header("Location: $baseUrl");
                    exit();
                }
    
                $questionID = $_GET['id'];
                $data['question'] = $this->questionModel->getQuestionById($questionID);
                $data['difficulty'] = $this->questionModel->calculateQuestionDifficulty($questionID);
                // Renderizar el formulario de reporte
                $this->renderer->render("report_question", $data);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!isset($_POST['id']) || !isset($_POST['reportReason'])) {
                    $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
                    header("Location: $baseUrl");
                    exit();
                }
    
                $questionID = $_POST['id'];
                $reportReason = $_POST['reportReason'];
    
                // Crear el reporte de pregunta
                if($this->ReportedQuestionModel->createReportedQuestion($questionID, $loggedInUserId, $reportReason)){
                    $data['resultado'] = "enviado";
                }
                
                $this->renderer->render("report_question", $data);
                // Cerrar la página
                exit();
            }else{
                $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
                header("Location: $baseUrl");
                exit();
            }
        } else {
            $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
            header("Location: $baseUrl");
            exit();
        }
    }


}
