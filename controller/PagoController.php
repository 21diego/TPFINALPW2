<?php
include_once ("helper/ValidarPagoForm.php");
class PagoController{
    private $renderer;

    /**
     * PagoController constructor.
     * @param Renderer $renderer
     */
    public function __construct($renderer){
        $this->renderer = $renderer;
    }

    public function getPagoForm(){
       $ideditorial = isset($_GET["ideditorial"]) ? $_GET["ideditorial"] : false;
       $idsuscripcion = isset($_GET["idsuscripcion"]) ? $_GET["idsuscripcion"] : false;
       $idpublicacion = isset($_GET["idpublicacion"]) ? $_GET["idpublicacion"] : false;

       if($idpublicacion == false){
           $data = array("ideditorial" => $ideditorial, "idsuscripcion" => $idsuscripcion);
           $this->renderer->render("view/pago/pagoForm.mustache",$data);
       }else{
           $data = array("idpublicacion" => $idpublicacion);
           $this->renderer->render("view/pago/pagoForm.mustache",$data);
       }
    }

    public function postValidarForumulario(){
        $data = array();
        $nroTarjeta = $_POST["nroTarjeta"];
        $codigo = $_POST["codigo"];
        $dni = $_POST["dni"];
        if(ValidarPagoForm::validarNroTarjeta($nroTarjeta) == false) {
            $data["errorNroTarjeta"] = "Numero de tarjeta inválido";
        }
        if(ValidarPagoForm::validarCodigoSeguridad($codigo) == false){
            $data["errorCodigo"] = "Codigo de seguridad inválido";
        }
        if(ValidarPagoForm::validarDni($dni) == false){
            $data["errorDni"] = "Numero de dni inválido";
        }
        $idpublicacion = isset($_GET["idpublicacion"]) ? $_GET["ididpublicacion"] : false;
        if($idpublicacion == false){
            $ideditorial = $_GET["ideditorial"];
            $idsuscripcion = $_GET["idsuscripcion"];
            if(!empty($data)){
                $date["ideditorial"] = $ideditorial;
                $date["idsuscripcion"] = $idsuscripcion;
                $this->renderer->render("view/pago/pagoForm.mustache", $data);
            }else{
                header("Location: http://localhost/suscripcion/Suscribirse?ideditorial=$ideditorial&idsuscripcion=$idsuscripcion");
            }
        }else{
            if(!empty($data)){
                $date["idpublicacion"] = $idpublicacion;
                $this->renderer->render("view/pago/pagoForm.mustache", $data);
            }else{
                header("Location: http://localhost/compra/Comprar?idpublicacion=$idpublicacion");
            }
        }
        }
}
?>