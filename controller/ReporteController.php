<?php
require_once 'helper/PDF.php';

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
        $pdf = new PDF('Reporte Mensual de Infonete');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Content($this->reporteModel);
        $pdf->Output('i','reporte-mensual.pdf');
    }







}