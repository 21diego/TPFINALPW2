<?php

require_once 'helper/PDF.php';
include_once ("model/Rol.php");
include_once ("helper/Library.php");
class reporteController{
    private $renderer;
    private $reporte;

    /**
     * reporteController constructor.
     * @param Renderer $renderer
     * @param ReporteModel $reporteModel
     */
    public function __construct($renderer, $reporteModel){
        $this->renderer = $renderer;
        $this->reporte = $reporteModel;
    }

    public function getReporte(){
        if($_SESSION["usuario"]["rol"] != Rol::Admin){
            header("Location: http://localhost/dashboard");
        }
        $cantSuscripciones = $this->reporte->getcantidadTotalSuscripciones();
        $recaudacionSuscripciones = $this->reporte->getrecaudacionTotalSuscripciones();
        $cantCompras = $this->reporte->getcantidadTotalCompras();
        $recaudacionCompras = $this->reporte->getrecaudacionTotalCompras();
        $totalRecaudacion = (intval($recaudacionCompras) + intval($recaudacionSuscripciones));
        $totalCant = (intval($cantCompras)+ intval($cantSuscripciones));

        $data = array("cs" => $cantSuscripciones, "rs" => $recaudacionSuscripciones,
            "cc" => $cantCompras, "rc" => $recaudacionCompras, "rt" => $totalRecaudacion, "ct" => $totalCant);

        $this->renderer->render("view/reporte/index.mustache", $data);
    }

    public function getReporteUsuarios(){
        if($_SESSION["usuario"]["rol"] != Rol::Admin){
            header("Location: http://localhost/dashboard");
        }
        $cantUsuariosGratis = $this->reporte->getCantidadDeUsuariosGratuitos();
        $cantUsuariosPagos = $this->reporte->getCantidadDeUsuariosPagos();
        $totalUsuarios = intval($cantUsuariosGratis) + intval($cantUsuariosPagos);

        $data = array("ug" => $cantUsuariosGratis, "up" => $cantUsuariosPagos, "ut" => $totalUsuarios);
        $this->renderer->render("view/reporte/reporte-usuarios.mustache", $data);
    }

    public function getReporteEditorial(){
        if($_SESSION["usuario"]["rol"] != Rol::Admin){
            header("Location: http://localhost/dashboard");
        }
        $editoriales = $this->reporte->getCantPublicacionesXEditorial();
        $data = array("editoriales" => $editoriales);
        $this->renderer->render("view/reporte/reporte-editorial.mustache", $data);
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
        $pdf->Content($this->reporte, $data);
        $pdf->Output('i','reporte-mensual.pdf');
    }

}
?>

