<?php
require_once 'third-party/fpdf/fpdf.php';

class PDF extends FPDF {
    private $title;
    // Cabecera de página
    /**
     * PDF constructor.
     */
    public function __construct($title) {
        parent::__construct();
        $this->title = $title;
    }

    function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial','BU',20);
        // Título
        $this->Cell(100,10,$this->title,0,0,'C');
        // Salto de línea
        $this->Ln(20);
    }

    function Content($reporte){
        $mesActual = date('n');
        $anioActual = date('Y');
        $this->InsertRow('Recaudacion Total Suscripciones  del mes '.date('F'),'$'.$reporte->getrecaudacionTotalSuscripcionesXmes($mesActual, $anioActual));

    }

    private function InsertRow($key,$value){
        $this->Cell(130,10,$key,1,0,'C',0);
        $this->Cell(60,10,$value,1,1,'C',0);
    }

// Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}
