<?php
require_once 'helper/PDF.php';
require_once 'helper/Library.php';

class ReporteController {

    private $renderer;
    private $reporteModel;

    /**
     * ReporteController constructor.
     * @param Renderer $renderer
     * @param ReporteModel $reporteModel
     */
    public function __construct($renderer, $reporteModel) {
        $this->renderer = $renderer;
        $this->reporteModel = $reporteModel;
    }

    public function getGenerarReporteMensual(){
        $data = array(
                "mesactual" => date('F'),
                "mesactualnro" => date('n'),
                "anioactual" => date('Y')
        );
        $this->renderer->render('view/admin/generarReporte.mustache',$data);

    }

    public function postGenerarReporteMensual(){
        $mes = $_POST['mes'];
        $mesnro = $_POST['mesnro'];
        $anio = $_POST['anio'];
        $data = array("mes"=>$mesnro, "anio"=>$anio, "reporte" => $_POST['data']);
        $title = "Reporte Mensual de Infonete [$mes - $anio]";
        $pdf = new PDF($title);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Content($this->reporteModel, $data);
        $pdf->Output('i','reporte-mensual.pdf');
    }







}