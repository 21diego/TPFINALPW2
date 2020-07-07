<?php
include_once ("dao/SuscripcionDAO.php");
include_once ("dao/UsuarioDAO.php");

class SuscripcionController{
    private $renderer;
    private $suscripcion;
    private $usuario;


    /**
     * SuscripcionController constructor.
     * @param Renderer $renderer
     * @param SuscripcionDAO $suscripcionDAO
     * @param UsuarioDAO $usuarioDao
     */
    public function __construct($renderer, $suscripcionDAO, $usuarioDao)
    {
        $this->renderer= $renderer;
        $this->suscripcion = $suscripcionDAO;
        $this->usuario = $usuarioDao;
    }

    public function getSuscripciones(){
        $idEditorial = $_GET["ideditorial"];
        $idUsuario = $_SESSION["usuario"]["idUsuario"];
        try {
            $suscripcion = $this->suscripcion->buscarSuscripcion($idUsuario, $idEditorial);
                $this->renderer->render("view/publicacion/content.mustache", array());
        }catch (EntityNotFoundException $ene){
            $suscripciones = $this->suscripcion->getSuscripciones();
            $data = array("suscripciones" => $suscripciones, "editorial" => $idEditorial);
            $this->renderer->render("view/suscripciones/suscripciones.mustache", $data);
        }
    }
    public function getSuscribirse(){
        $idEditorial = intval($_GET["ideditorial"]);
        $idSuscripcion = intval($_GET["idsuscripcion"]);
        $idUsuario = intval($_SESSION["usuario"]["idUsuario"]);

        $usuario = $this->usuario->getUsuarioById($idUsuario);
        if($usuario["rol"] == Rol::Usuario) {
            $usuario["rol"] = Rol::Suscriptor;
            $this->usuario->updateUsuario($usuario);
        }
        $this->suscripcion->suscribirse($idUsuario,$idSuscripcion, $idEditorial);

        header("Location: http://localhost/dashboard");
    }

    public function getSuscripcionesUsuario(){
        $idUsuario = $_SESSION["usuario"]["idUsuario"];
        $suscripciones = $this->suscripcion->getSuscripcionesByUsuario($idUsuario);

        $data = array("suscripciones" => $suscripciones);
        $this->renderer->render("view/suscripciones/suscripciones-usuario.mustache", $data);
}
}
?>