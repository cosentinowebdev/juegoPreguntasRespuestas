<?php

/**
 * clase de manejo de sesiones
 */
class Graficos{
    private $filename;
    public function __construct(){
        $this->filename = 'imagen/barchart.png';
    }
    function generateUsuariosActivosBarChartBase64($data) {
        // Crear el gráfico de barras
        require_once 'helpers/jpgraph/src/jpgraph.php';
        require_once 'helpers/jpgraph/src/jpgraph_bar.php';
    
        $datay=$data["playersCount"];

        
        // Create the graph. These two calls are always required
        $graph = new Graph(350,220,'auto');
        $graph->SetScale("textlin");

        //$theme_class="DefaultTheme";
        //$graph->SetTheme(new $theme_class());

        // set major and minor tick positions manually
        $graph->yaxis->SetTickPositions(array(0,5,10), array(5,7,12));
        $graph->SetBox(false);

        //$graph->ygrid->SetColor('gray');
        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels($data["date"]);
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false,false);

        // Create the bar plots
        $b1plot = new BarPlot($datay);

        // ...and add it to the graPH
        $graph->Add($b1plot);


        $b1plot->SetColor("white");
        $b1plot->SetFillGradient("#4B0082","white",GRAD_LEFT_REFLECTION);
        $b1plot->SetWidth(45);
        $graph->title->Set("Bar Gradient(Left reflection)");
        $filename = 'imagen/barchartUsuariosActivos.png';
        // Display the graph
        $graph->Stroke($filename);
        $imageData = file_get_contents($filename);
        $imageBase64 = base64_encode($imageData);
        file_put_contents($filename, $imageData);
        return $imageBase64;
    }
    function generateUsuariosEdadBarChartBase64($data) {
        // Crear el gráfico de barras
        require_once 'helpers/jpgraph/src/jpgraph.php';
        require_once 'helpers/jpgraph/src/jpgraph_bar.php';
        
        $datay = $data["count"];
        $datay = array_map('intval', $datay);
    
        // Crear el objeto de gráfico
        $graph = new Graph(350, 220, 'auto');
        $graph->SetScale('textint', 0, 10);
        $graph->SetBox(false);
        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels($data["ageGroup"]);
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false, false);
    
        // Crear el objeto de barras
        $b1plot = new BarPlot($datay);
    
        // Asignar el objeto de barras al gráfico
        $graph->Add($b1plot);
    
        // Configurar el objeto de barras
        $b1plot->SetColor("white");
        $b1plot->SetFillGradient("#4B0082", "white", GRAD_LEFT_REFLECTION);
        $b1plot->SetWidth(45);
        $graph->title->Set("Bar Gradient(Left reflection)");
    
        // Generar la ruta y nombre del archivo de imagen
        $filename = 'imagen/barchartUsuariosEdad.png';
    
        // Generar la imagen del gráfico
        $graph->Stroke($filename);
    
        // Obtener los datos de la imagen generada
        $imageData = file_get_contents($filename);
        $imageBase64 = base64_encode($imageData);
    
        // Guardar la imagen sobrescribiendo el archivo existente
        file_put_contents($filename, $imageData);
    
        // Devolver la imagen en formato base64
        return $imageBase64;
    }
    function generateUsuariosSexoBarChartBase64($data) {
        // Crear el gráfico de barras
        require_once 'helpers/jpgraph/src/jpgraph.php';
        require_once 'helpers/jpgraph/src/jpgraph_bar.php';
        
        $datay = $data["UsersCount"];
        $datay = array_map('intval', $datay);
    
        // Crear el objeto de gráfico
        $graph = new Graph(350, 220, 'auto');
        $graph->SetScale('textint', 0, 10);
        $graph->SetBox(false);
        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels($data["Gender"]);
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false, false);
    
        // Crear el objeto de barras
        $b1plot = new BarPlot($datay);
    
        // Asignar el objeto de barras al gráfico
        $graph->Add($b1plot);
    
        // Configurar el objeto de barras
        $b1plot->SetColor("white");
        $b1plot->SetFillGradient("#4B0082", "white", GRAD_LEFT_REFLECTION);
        $b1plot->SetWidth(45);
        $graph->title->Set("Bar Gradient(Left reflection)");
    
        // Generar la ruta y nombre del archivo de imagen
        $filename = 'imagen/barchartUsuariosSexo.png';
    
        // Generar la imagen del gráfico
        $graph->Stroke($filename);
    
        // Obtener los datos de la imagen generada
        $imageData = file_get_contents($filename);
        $imageBase64 = base64_encode($imageData);
    
        // Guardar la imagen sobrescribiendo el archivo existente
        file_put_contents($filename, $imageData);
    
        // Devolver la imagen en formato base64
        return $imageBase64;
    }
    function generateUsuariosPaisBarChartBase64($data) {
        // Crear el gráfico de barras
        require_once 'helpers/jpgraph/src/jpgraph.php';
        require_once 'helpers/jpgraph/src/jpgraph_bar.php';

        $datay = $data["UsersCount"];
        $datay = array_map('intval', $datay);
    
        // Crear el objeto de gráfico
        $graph = new Graph(350, 220, 'auto');
        $graph->SetScale('textint', 0, 10);
        $graph->SetBox(false);
        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels($data["Country"]);
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false, false);
    
        // Crear el objeto de barras
        $b1plot = new BarPlot($datay);
    
        // Asignar el objeto de barras al gráfico
        $graph->Add($b1plot);
    
        // Configurar el objeto de barras
        $b1plot->SetColor("white");
        $b1plot->SetFillGradient("#4B0082", "white", GRAD_LEFT_REFLECTION);
        $b1plot->SetWidth(45);
        $graph->title->Set("Bar Gradient(Left reflection)");
    
        // Generar la ruta y nombre del archivo de imagen
        $filename = 'imagen/barchartUsuariosPais.png';
    
        // Generar la imagen del gráfico
        $graph->Stroke($filename);
    
        // Obtener los datos de la imagen generada
        $imageData = file_get_contents($filename);
        $imageBase64 = base64_encode($imageData);
    
        // Guardar la imagen sobrescribiendo el archivo existente
        file_put_contents($filename, $imageData);
    
        // Devolver la imagen en formato base64
        return $imageBase64;
    }
    function generateUsuariosPorcentajeBarChartBase64($data) {
        // Crear el gráfico de barras
        require_once 'helpers/jpgraph/src/jpgraph.php';
        require_once 'helpers/jpgraph/src/jpgraph_bar.php';

        $datay = $data["CorrectAnswerPercentage"];
        $datay = array_map('intval', $datay);
    
        // Crear el objeto de gráfico
        $graph = new Graph(350, 220, 'auto');
        $graph->SetScale('textint', 0, 100);
        $graph->SetBox(false);
        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels($data["FullName"]);
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false, false);
    
        // Crear el objeto de barras
        $b1plot = new BarPlot($datay);
    
        // Asignar el objeto de barras al gráfico
        $graph->Add($b1plot);
    
        // Configurar el objeto de barras
        $b1plot->SetColor("white");
        $b1plot->SetFillGradient("#4B0082", "white", GRAD_LEFT_REFLECTION);
        $b1plot->SetWidth(45);
        $graph->title->Set("Porcentaje Exito Por Usuario");
    
        // Generar la ruta y nombre del archivo de imagen
        $filename = 'imagen/barchartUsuariosPorcentaje.png';
    
        // Generar la imagen del gráfico
        $graph->Stroke($filename);
    
        // Obtener los datos de la imagen generada
        $imageData = file_get_contents($filename);
        $imageBase64 = base64_encode($imageData);
    
        // Guardar la imagen sobrescribiendo el archivo existente
        file_put_contents($filename, $imageData);
    
        // Devolver la imagen en formato base64
        return $imageBase64;
    }
    function generateCategoriaPieChartBase64($data) {
        // Crear el gráfico de barras
        require_once 'helpers/jpgraph/src/jpgraph.php';
        require_once 'helpers/jpgraph/src/jpgraph_pie.php';
        // Some data
        $data = $data["percentage"];

        // Create the Pie Graph. 
        $graph = new PieGraph(350,250);

        $theme_class="DefaultTheme";
        //$graph->SetTheme(new $theme_class());

        // Set A title for the plot
        $graph->title->Set("Cantidad Preguntas Por Categoria");
        $graph->SetBox(true);

        // Create
        $p1 = new PiePlot($data);
        $graph->Add($p1);

        $p1->ShowBorder();
        $p1->SetColor('black');
        $p1->SetSliceColors($data["CategoryColor"]);
    
        // Generar la ruta y nombre del archivo de imagen
        $filename = 'imagen/piechartCategoria.png';
    
        // Generar la imagen del gráfico
        $graph->Stroke($filename);
    
        // Obtener los datos de la imagen generada
        $imageData = file_get_contents($filename);
        $imageBase64 = base64_encode($imageData);
    
        // Guardar la imagen sobrescribiendo el archivo existente
        file_put_contents($filename, $imageData);
    
        // Devolver la imagen en formato base64
        return $imageBase64;
    }
    function generateGamesLineChartBase64($data) {
        // Crear el gráfico de barras
        require_once 'helpers/jpgraph/src/jpgraph.php';
        require_once 'helpers/jpgraph/src/jpgraph_line.php';
        require_once 'helpers/jpgraph/src/jpgraph_date.php';
        
        
        // Setup the graph
        $graph = new Graph(300,250);
        $graph->SetScale('datlin');
        
        $theme_class=new UniversalTheme;
        
        $graph->SetTheme($theme_class);
        $graph->img->SetAntiAliasing(false);
        $graph->title->Set('Filled Y-grid');
        $graph->SetBox(false);
        
        $graph->SetMargin(40,20,36,63);
        
        $graph->img->SetAntiAliasing();
        
        $graph->yaxis->HideZeroLabel();
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false,false);
        
        $graph->xgrid->Show();
        $graph->xgrid->SetLineStyle("solid");
        $graph->xaxis->SetTickLabels($data['GameDate']);
        $graph->xgrid->SetColor('#E3E3E3');
        
        // Create the first line
        $p1 = new LinePlot($data['GamesCount']);
        $graph->Add($p1);
        $p1->SetColor("#6495ED");
        $p1->SetLegend('Cantidad Partidas');
        
        $graph->legend->SetFrameWeight(1);
        
        // Generar la ruta y nombre del archivo de imagen
        $filename = 'imagen/linechartGame.png';
    
        // Generar la imagen del gráfico
        $graph->Stroke($filename);
    
        // Obtener los datos de la imagen generada
        $imageData = file_get_contents($filename);
        $imageBase64 = base64_encode($imageData);
    
        // Guardar la imagen sobrescribiendo el archivo existente
        file_put_contents($filename, $imageData);
    
        // Devolver la imagen en formato base64
        return $imageBase64;
    }


}