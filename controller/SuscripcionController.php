<?php
include_once ("dao/SuscripcionDAO.php");
include_once ("dao/UsuarioDAO.php");
include_once ("dao/PublicacionDAO.php");

class SuscripcionController{
    private $renderer;
    private $suscripcion;
    private $usuario;
    private $publicacion;
    private $compra;


    /**
     * SuscripcionController constructor.
     * @param Renderer $renderer
     * @param SuscripcionDAO $suscripcionDAO
     * @param UsuarioDAO $usuarioDao
     * @param PublicacionDAO $publicacionDAO
     * @param CompraDAO $compraDAO
     */
    public function __construct($renderer, $suscripcionDAO, $usuarioDao, $publicacionDAO,$compraDAO)
    {
        $this->renderer= $renderer;
        $this->suscripcion = $suscripcionDAO;
        $this->usuario = $usuarioDao;
        $this->publicacion = $publicacionDAO;
        $this->compra = $compraDAO;
    }

    public function getSuscripciones(){
        $idEditorial = $_GET["ideditorial"];
        $idpublicacion = $_GET["idpublicacion"];
        $idUsuario = $_SESSION["usuario"]["idUsuario"];
        try {
            $suscripcion = $this->suscripcion->buscarSuscripcion($idUsuario, $idEditorial);
            $today = Library::getTodayArg();
            $fechaFin = new DateTime($suscripcion["fechaFin"]);
            if($today > $fechaFin){
                throw new EntityNotFoundException("","");
            }
                $this->renderer->render("view/publicacion/content.mustache", array());
        }catch (EntityNotFoundException $ene){
            try {
                $compra = $this->compra->buscarCompra($idUsuario, $idpublicacion);
                $this->renderer->render("view/publicacion/content.mustache", array());
            }catch (EntityNotFoundException $ene){
                $suscripciones = $this->suscripcion->getSuscripciones();
                $publicacion = $this->publicacion->getPublicacionId($idpublicacion);
                $data = array("suscripciones" => $suscripciones, "editorial" => $idEditorial, "publicacion" => $publicacion);
                $this->renderer->render("view/suscripciones/suscripciones.mustache", $data);
            }
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