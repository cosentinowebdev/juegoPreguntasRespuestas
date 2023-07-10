<?php

class QuestionController {
    private $questionModel;
    private $renderer;
    private $session;
    private $utilitiesModel;
    private $reportedQuestionModel;

    public function __construct($questionModel, $session, $utilitiesModel, $reportedQuestionModel, $renderer) {
        $this->questionModel = $questionModel;
        $this->renderer = $renderer;
        $this->session = $session;
        $this->utilitiesModel = $utilitiesModel;
        $this->reportedQuestionModel = $reportedQuestionModel;
    }
    public function list(){
        $questionsData = $this->questionModel->getAllQuestions();

        // $data = $this->session->getData();
        
        $data = $this->session->getData();

        if ($data["isLoggedIn"] && ($data["isEditor"] || $data["isAdmin"])) {
            $data["questionsData"]= $questionsData;
            $this->renderer->render("list_question", $data);

        } else {

            $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
            $baseUrl= $baseUrl."user/lobby";
            header("Location: $baseUrl");
            exit();
        }
    }
    public function create()
    {
        $data = $this->session->getData();
        $Categories = $this->utilitiesModel->getCategories();
        $data['categories'] = $Categories;
    
        if ($data["isLoggedIn"] && ($data["isEditor"] || $data["isAdmin"])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $questionText = $_POST["questionText"];
                $correctAnswer = $_POST["correctAnswer"];
                $answer1 = $_POST["answer1"];
                $answer2 = $_POST["answer2"];
                $answer3 = $_POST["answer3"];
                $categoryID = $_POST["categoryID"];
                $StateID = 3;
                
                $errors = array();
    
                if (empty($questionText)) {
                    $errors[] = "El campo 'Pregunta' es obligatorio.";
                }
    
                if (empty($correctAnswer)) {
                    $errors[] = "El campo 'Respuesta Correcta' es obligatorio.";
                }
    
                if (empty($answer1)) {
                    $errors[] = "El campo 'Respuesta 1' es obligatorio.";
                }
    
                if (empty($answer2)) {
                    $errors[] = "El campo 'Respuesta 2' es obligatorio.";
                }
    
                if (empty($answer3)) {
                    $errors[] = "El campo 'Respuesta 3' es obligatorio.";
                }
    
                if (empty($categoryID)) {
                    $errors[] = "Debe seleccionar una categoría.";
                }
    
                if (empty($errors)) {
                    $this->questionModel->createQuestion($questionText, $correctAnswer, $answer1, $answer2, $answer3, $categoryID, $StateID);
                    // Redireccionar al usuario a la página de éxito o a donde desees
                } else {
                    $data['errors'] = $errors;
                    $this->renderer->render("create_question", $data);
                }
                $data['success']=true;
                $this->renderer->render("create_question", $data);
            } else {
                $this->renderer->render("create_question", $data);
            }
        } else {
            // Redireccionar al usuario a la página de error
            $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
            $baseUrl = $baseUrl . "user/lobby";
            header("Location: $baseUrl");
            exit();
        }
    }
    public function edit(){
        $data = $this->session->getData();
        $categories = $this->utilitiesModel->getCategories();
        $states = $this->utilitiesModel->getStates();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if ($data["isLoggedIn"] && ($data["isEditor"] || $data["isAdmin"])) {
                $idUpdate = $_GET["id"];
                $question = $this->questionModel->getQuestionById($idUpdate);
                $data['question']=$question;
    
                foreach ($categories as &$category) {
                    $category['habilitado'] = ($category['CategoryID'] == $question['CategoryID']);
                }
                
                foreach ($states as &$state) {
                    $state['habilitado'] = ($state['StateID'] == $question['StateID']);
                }
    
                $data['categories'] = $categories;
                $data['states'] = $states;

                $this->renderer->render("edit_question", $data);
            }else {

                $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
                $baseUrl= $baseUrl."user/lobby";
                header("Location: $baseUrl");
                exit();
            }

        }else if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $idUpdate = $_POST['questionID'];
            $question = $this->questionModel->updateQuestion(
                $_POST['questionID'],
                $_POST['questionText'],
                $_POST['correctAnswer'],
                $_POST['answer1'],
                $_POST['answer2'],
                $_POST['answer3'],
                $_POST['categoryID'],
                $_POST['stateID']
            );
            $data['question']=$question;
            $data['success']=true;
    
            foreach ($categories as &$category) {
                $category['habilitado'] = ($category['CategoryID'] == $question['CategoryID']);
            }
            
            foreach ($states as &$state) {
                $state['habilitado'] = ($state['StateID'] == $question['StateID']);
            }

            $data['categories'] = $categories;
            $data['states'] = $states;

            $this->renderer->render("edit_question", $data);
        }else{
            $this->renderer->render("list_question", $data);
        }
    }
    public function list_categories(){
        $data = $this->session->getData();
        $Categories = $this->utilitiesModel->getCategories();
        $data['categories'] = $Categories;
        if ($data["isLoggedIn"] && ($data["isEditor"] || $data["isAdmin"])) {
            $this->renderer->render("list_categories", $data);

        } else {

            $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
            $baseUrl= $baseUrl."user/lobby";
            header("Location: $baseUrl");
            exit();
        }
    }
    public function list_reported(){
        $reportedQuestionsData = $this->reportedQuestionModel->listReportedQuestions();

        $data = $this->session->getData();
        $data["reportedQuestionsData"]= $reportedQuestionsData;
        if ($data["isLoggedIn"] && ($data["isEditor"] || $data["isAdmin"])) {

            $this->renderer->render("list_reportedquestion", $data);

        } else {

            $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
            $baseUrl= $baseUrl."user/lobby";
            header("Location: $baseUrl");
            exit();
        }

    }
    public function fix_reported(){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $idUpdate = $_GET["id"];


            $data = $this->session->getData();
            
            if ($data["isLoggedIn"] && ($data["isEditor"] || $data["isAdmin"])) {
                $reportedQuestionsData = $this->reportedQuestionModel->updateReportedQuestion($idUpdate,'fixed');
                $data["reportedQuestionsData"]= $reportedQuestionsData;
                $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
                $baseUrl= $baseUrl."question/list_reported";
                header("Location: $baseUrl");
                exit();

            } else {

                $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
                $baseUrl= $baseUrl."user/lobby";
                header("Location: $baseUrl");
                exit();
            }
        }else{
            $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
            $baseUrl= $baseUrl."user/lobby";
            header("Location: $baseUrl");
            exit();
        }
    }


}
