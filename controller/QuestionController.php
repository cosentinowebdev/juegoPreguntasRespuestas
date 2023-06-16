<?php

class QuestionController {
    private $questionModel;
    private $renderer;
    private $session;
    private $utilitiesModel;

    public function __construct($questionModel, $session, $utilitiesModel, $renderer) {
        $this->questionModel = $questionModel;
        $this->renderer = $renderer;
        $this->session = $session;
        $this->utilitiesModel = $utilitiesModel;
    }
    public function list(){
        $questionsData = $this->questionModel->getAllQuestions();

        $data = $this->session->getData();
        $data["questionsData"]= $questionsData;

        if ($data["isLoggedIn"] && ($data["isEditor"] || $data["isAdmin"])) {

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

}
