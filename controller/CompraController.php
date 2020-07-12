<?php
class CompraController{
private $renderer;
private $compra;

    /**
     * CompraController constructor.
     * @param Renderer $renderer
     * @param CompraDAO $compraDAO
     */
    public function __construct($renderer, $compraDAO){
    $this->renderer = $renderer;
    $this->compra = $compraDAO;
}

    public function getComprar(){
        $idusuario = $_SESSION["usuario"]["idUsuario"];
        $idpublicacion = $_GET["idpublicacion"];

        try{
            $this->compra->postCompra($idusuario, $idpublicacion);
            header("Location: http://localhost/dashboard");
        }catch (Exception $e){

        }
    }
}
?>