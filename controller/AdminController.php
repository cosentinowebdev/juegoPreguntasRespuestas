<?php
require_once 'helpers/jpgraph/src/jpgraph.php';
require_once 'helpers/jpgraph/src/jpgraph_bar.php';
require_once 'helpers/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

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
                $this->renderer->render("estadisticas",$data);
            }else if($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['startDate']){
                $startDate = $_GET['startDate'];
                $endDate = $_GET['endDate'];

                $usuariosActivos = $this->userModel->getAccountStatusPlayersCount('Active', $startDate, $endDate);
                $usuariosPorEdad = $this->userModel->getUsersCountByAgeGroup($startDate, $endDate);
                $usuariosPorSexo = $this->userModel->getUsersCountByGender($startDate, $endDate);
                $usuariosPorPais = $this->userModel->getUsersCountByCountry($startDate, $endDate);
                $preguntarCorrectasPorUsuario = $this->questionModel->getUsersCorrectAnswerPercentage($startDate, $endDate);
                $preguntarPorCategoria = $this->questionModel->getQuestionsCountByCategory();
                $jugadasPorFecha = $this->questionModel->getGamesCountByCreationDate($startDate, $endDate);

                $barcharUsuariosActivos=$this->graficos->generateUsuariosActivosBarChartBase64($usuariosActivos);
                
                $barcharUsuariosPorEdad=$this->graficos->generateUsuariosEdadBarChartBase64($usuariosPorEdad);
                
                $barcharUsuariosPorSexo = $this->graficos->generateUsuariosSexoBarChartBase64($usuariosPorSexo);
                
                $barcharUsuariosPorPais = $this->graficos->generateUsuariosPaisBarChartBase64($usuariosPorPais);
                
                $barcharUsuarioPorcentaje = $this->graficos->generateUsuariosPorcentajeBarChartBase64($preguntarCorrectasPorUsuario);
                
                $piecharCategoriaPorcentaje = $this->graficos->generateCategoriaPieChartBase64($preguntarPorCategoria);
                
                $linecharJugadas = $this->graficos->generateGamesLineChartBase64($jugadasPorFecha);
                // instantiate and use the dompdf class
                $options = new Options();
                $options->set('defaultFont', 'Courier');
                $dompdf = new Dompdf($options);
                $dompdf->loadHtml("
                <!DOCTYPE html>
                <html lang='es'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Estadisticas</title>
                </head>
                <body>
                    <div style='width: 210mm; height: 297mm; margin: 20mm auto; font-family: Arial, sans-serif;'>
                        <h2 style='font-size: 24px; font-weight: bold; margin-bottom: 20px;'>Estadisticas</h2>
                        <div style='display: flex; flex-wrap: wrap;'>
                            <!-- Imagen 1 -->
                            <div style='width: 33%; padding-right: 10px; margin-bottom: 20px;'>
                                <div style='border: 1px solid #ccc; border-radius: 5px; overflow: hidden;'>
                                    <img src='data:image/png;base64,$barcharUsuariosActivos' style='width: 100%; display: block;' alt='Gráfico 1'>
                                </div>
                            </div>
                            
                            <!-- Imagen 2 -->
                            <div style='width: 33%; padding-right: 10px; margin-bottom: 20px;'>
                                <div style='border: 1px solid #ccc; border-radius: 5px; overflow: hidden;'>
                                    <img src='data:image/png;base64,$barcharUsuariosPorEdad' style='width: 100%; display: block;' alt='Gráfico 2'>
                                </div>
                            </div>
                            
                            <!-- Imagen 3 -->
                            <div style='width: 33%; padding-right: 10px; margin-bottom: 20px;'>
                                <div style='border: 1px solid #ccc; border-radius: 5px; overflow: hidden;'>
                                    <img src='data:image/png;base64,$barcharUsuariosPorSexo' style='width: 100%; display: block;' alt='Gráfico 3'>
                                </div>
                            </div>
                            
                            <!-- Imagen 4 -->
                            <div style='width: 33%; padding-right: 10px; margin-bottom: 20px;'>
                                <div style='border: 1px solid #ccc; border-radius: 5px; overflow: hidden;'>
                                    <img src='data:image/png;base64,$barcharUsuariosPorPais' style='width: 100%; display: block;' alt='Gráfico 4'>
                                </div>
                            </div>
                            
                            <!-- Imagen 5 -->
                            <div style='width: 33%; padding-right: 10px; margin-bottom: 20px;'>
                                <div style='border: 1px solid #ccc; border-radius: 5px; overflow: hidden;'>
                                    <img src='data:image/png;base64,$barcharUsuarioPorcentaje' style='width: 100%; display: block;' alt='Gráfico 5'>
                                </div>
                            </div>
                            
                            <!-- Imagen 6 -->
                            <div style='width: 33%; padding-right: 10px; margin-bottom: 20px;'>
                                <div style='border: 1px solid #ccc; border-radius: 5px; overflow: hidden;'>
                                    <img src='data:image/png;base64,$piecharCategoriaPorcentaje' style='width: 100%; display: block;' alt='Gráfico 6'>
                                </div>
                            </div>
                            
                            <!-- Imagen 7 -->
                            <div style='width: 33%; padding-right: 10px; margin-bottom: 20px;'>
                                <div style='border: 1px solid #ccc; border-radius: 5px; overflow: hidden;'>
                                    <img src='data:image/png;base64,$linecharJugadas' style='width: 100%; display: block;' alt='Gráfico 7'>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </body>
                </html>

                ");

                // (Optional) Setup the paper size and orientation
                $dompdf->setPaper('A4');

                // Render the HTML as PDF
                $dompdf->render();

                // Output the generated PDF to Browser
                $dompdf->stream();
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
                $this->renderer->render("estadisticas",$data);
            }
            
        }else{
            // Si no se encuentra el usuario, redirigir o mostrar un mensaje de error
            $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
            header("Location: $baseUrl");
            exit();
        }
    }
}