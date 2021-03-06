<?php

include_once "dao/EditorialDAO.php";
include_once "dao/ContenidistaDAO.php";
include_once "dao/UsuarioDAO.php";
include_once "model/Rol.php";

class ContenidistaController{

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
        $this->renderer->render("view/verificar-contenidista.mustache",array());
    }

    public function postVerificar(){

        $cuit = $_POST["cuit"];


        try{
            $ideditorial = $this->editorial->getEditorial($cuit)['ideditorial'];
            $_SESSION['usuario']['rol'] = Rol::Pendiente;
            $usuario = $_SESSION['usuario'];

            $this->contenidista->postContenidista($usuario['idUsuario'],$ideditorial);
            $this->usuario->updateUsuario($usuario);

            $this->renderer->render("view/dashboard.mustache",array());
        }
        catch (EntityNotFoundException $ex){
            $this->renderer->render("view/verificar-contenidista.mustache", array(
                    "error" => "No existe una editorial con ese cuit"
            ));
        }
        catch (AlreadyRequestException $ex){
            $this->renderer->render("view/verificar-contenidista.mustache", array(
                    "error" => "Ya enviaste una solicitud de aceptacion"
            ));
        }

    }

}