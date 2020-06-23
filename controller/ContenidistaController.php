<?php

include_once "dao/EditorialDAO.php";
include_once "dao/ContenidistaDAO.php";
include_once "dao/UsuarioDAO.php";
include_once "model/Rol.php";

class ContenidistaController {

    private $renderer;
    private $editorial;
    private $contenidista;
    private $usuario;

    /**
     * ContenidistaController constructor.
     * @param Renderer $renderer
     * @param EditorialDAO $editorial
     * @param ContenidistaDAO $contenidista
     * @param UsuarioDAO $usuario
     */
    public function __construct($renderer,$editorial,$contenidista,$usuario) {
        $this->renderer = $renderer;
        $this->editorial = $editorial;
        $this->contenidista = $contenidista;
        $this->usuario = $usuario;
    }

    public function getVerificar(){
        echo $this->renderer->render("view/verificar-contenidista.mustache");
    }

    public function postVerificar(){

        $cuit = $_POST["cuit"];


        try{
            $ideditorial = $this->editorial->getEditorial($cuit)['ideditorial'];
            $_SESSION['usuario']['rol'] = Rol::Pendiente;
            $usuario = $_SESSION['usuario'];

            $this->contenidista->postContenidista($usuario['idUsuario'],$ideditorial);
            $this->usuario->updateUsuario($usuario);

            echo $this->renderer->render("view/dashboard.mustache");
        }
        catch (EntityNotFoundException $ex){
            echo $this->renderer->render("view/verificar-contenidista.mustache", array(
                    "error" => "No existe una editorial con ese cuit"
            ));
        }

    }

}