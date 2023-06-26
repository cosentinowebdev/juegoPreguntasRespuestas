<?php
require_once 'helpers/jpgraph/src/jpgraph.php';
require_once 'helpers/jpgraph/src/jpgraph_bar.php';

class AdminController {
    private $gameModel;
    private $questionModel;
    private $renderer;
    private $ReportedQuestionModel;
    private $session;
    private $userModel;
    private $graficos;

    public function __construct(
        $gameModel,
        $questionModel,
        $ReportedQuestionModel,
        $userModel,
        $renderer,
        $session,
        $graficos) {
        $this->gameModel = $gameModel;
        $this->questionModel = $questionModel;
        $this->ReportedQuestionModel = $ReportedQuestionModel;
        $this->userModel =$userModel;
        $this->renderer = $renderer;
        $this->session = $session;
        $this->graficos = $graficos;
    }
    public function list(){
        $data = $this->session->getData();
        if ($data["isLoggedIn"] && ($data["isEditor"] || $data["isAdmin"])) {
            $data["users"] = $this->userModel->getUser();
            $this->renderer->render("usuarios",$data);
        }else{
            // Si no se encuentra el usuario, redirigir o mostrar un mensaje de error
            $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
            header("Location: $baseUrl");
            exit();
        }
    }
    public function estadisticas(){
        $data = $this->session->getData();
        // var_dump($data);
        $startDate = '2023-03-01';
        $endDate = '2023-07-01';


        if ($data["isLoggedIn"] && ($data["isEditor"] || $data["isAdmin"])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                echo("linea 50");
                var_dump($endDate);
                echo("<hr>");
                echo("linea 53");
                var_dump($startDate);
                echo("<hr>");
                $usuariosActivos = $this->userModel->getAccountStatusPlayersCount('Active', $startDate, $endDate);
                $usuariosPorEdad = $this->userModel->getUsersCountByAgeGroup($startDate, $endDate);
                $usuariosPorSexo = $this->userModel->getUsersCountByGender($startDate, $endDate);
                $usuariosPorPais = $this->userModel->getUsersCountByCountry($startDate, $endDate);
                $preguntarCorrectasPorUsuario = $this->questionModel->getUsersCorrectAnswerPercentage($startDate, $endDate);
                $preguntarPorCategoria = $this->questionModel->getQuestionsCountByCategory();
                $jugadasPorFecha = $this->questionModel->getGamesCountByCreationDate($startDate, $endDate);
                
                $data["barcharUsuariosActivos"]=$this->graficos->generateUsuariosActivosBarChartBase64($usuariosActivos);
                
                $data["barcharUsuariosPorEdad"]=$this->graficos->generateUsuariosEdadBarChartBase64($usuariosPorEdad);
                
                $data["barcharUsuariosPorSexo"] = $this->graficos->generateUsuariosSexoBarChartBase64($usuariosPorSexo);
                
                $data["barcharUsuariosPorPais"] = $this->graficos->generateUsuariosPaisBarChartBase64($usuariosPorPais);
                
                $data["barcharUsuarioPorcentaje"] = $this->graficos->generateUsuariosPorcentajeBarChartBase64($preguntarCorrectasPorUsuario);
                
                $data["piecharCategoriaPorcentaje"] = $this->graficos->generateCategoriaPieChartBase64($preguntarPorCategoria);
                
                $data["linecharJugadas"] = $this->graficos->generateGamesLineChartBase64($jugadasPorFecha);
                $data["startDate"]=$startDate;
                $data["endDate"]=$endDate;
            }else{
                // Obtener la fecha actual en el formato 'Y-m-d'
                $endDate = date("Y-m-d");

                // Obtener la fecha del mes anterior a partir de la fecha actual
                $startDate = date("Y-m-d", strtotime("-1 month", strtotime($endDate)));
                $startDate = date("Y-m-t", strtotime($startDate));

                $usuariosActivos = $this->userModel->getAccountStatusPlayersCount('Active', $startDate, $endDate);
                $usuariosPorEdad = $this->userModel->getUsersCountByAgeGroup($startDate, $endDate);
                $usuariosPorSexo = $this->userModel->getUsersCountByGender($startDate, $endDate);
                $usuariosPorPais = $this->userModel->getUsersCountByCountry($startDate, $endDate);
                $preguntarCorrectasPorUsuario = $this->questionModel->getUsersCorrectAnswerPercentage($startDate, $endDate);
                $preguntarPorCategoria = $this->questionModel->getQuestionsCountByCategory();
                $jugadasPorFecha = $this->questionModel->getGamesCountByCreationDate($startDate, $endDate);

                $data["barcharUsuariosActivos"]=$this->graficos->generateUsuariosActivosBarChartBase64($usuariosActivos);
                
                $data["barcharUsuariosPorEdad"]=$this->graficos->generateUsuariosEdadBarChartBase64($usuariosPorEdad);
                
                $data["barcharUsuariosPorSexo"] = $this->graficos->generateUsuariosSexoBarChartBase64($usuariosPorSexo);
                
                $data["barcharUsuariosPorPais"] = $this->graficos->generateUsuariosPaisBarChartBase64($usuariosPorPais);
                
                $data["barcharUsuarioPorcentaje"] = $this->graficos->generateUsuariosPorcentajeBarChartBase64($preguntarCorrectasPorUsuario);
                
                $data["piecharCategoriaPorcentaje"] = $this->graficos->generateCategoriaPieChartBase64($preguntarPorCategoria);
                
                $data["linecharJugadas"] = $this->graficos->generateGamesLineChartBase64($jugadasPorFecha);
                $data["startDate"]=$startDate;
                $data["endDate"]=$endDate;
            }
            $this->renderer->render("estadisticas",$data);
        }else{
            // Si no se encuentra el usuario, redirigir o mostrar un mensaje de error
            $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
            header("Location: $baseUrl");
            exit();
        }
    }
}