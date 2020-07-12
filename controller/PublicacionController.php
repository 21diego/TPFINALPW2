<?php

require_once "helper/Library.php";
require_once "model/Publicacion.php";
require_once "model/EstadoDesarrollo.php";

class PublicacionController {

    private $renderer;
    private $publicacion;
    private $contenidista;
    private $noticia;

    /**
     * PublicacionController constructor.
     * @param Renderer $renderer
     * @param PublicacionDAO $publicacion
     * @param ContenidistaDAO $contenidista
     * @param NoticiaDAO $noticia
     */
    public function __construct($renderer,$publicacion,$contenidista,$noticia) {
        $this->renderer = $renderer;
        $this->publicacion = $publicacion;
        $this->contenidista = $contenidista;
        $this->noticia = $noticia;
    }

    public function getCrearPublicacion(){
        $idpublicacion = isset($_GET["idpublicacion"]) ? $_GET["idpublicacion"] : false;
        if($idpublicacion != false){
            $publicacion = $this->publicacion->getPublicacionEditableById($idpublicacion);
            $data = array("publicacion" => $publicacion);
        }
        else{
            $data = array();
        }
        $this->renderer->render("view/contenidista/crear-publicacion.mustache",$data);
    }

    public function postCrearPublicacion() {
        $nombre = $_POST['nombre'];
        $source = $_SERVER["DOCUMENT_ROOT"] . '/resources/';
        $name = Library::uploadImage($_FILES['portada'],$source);

        $query = $this->contenidista->getMiEditorial($_SESSION['usuario']['idUsuario']);
        $contenidista = $query['idUsuario'];
        $editorial = $query["editorial"];

        $publicacion = new Publicacion();
        $publicacion->setNombre($nombre);
        $publicacion->setPortada($name);
        $publicacion->setContenidistaEditor($contenidista);
        $publicacion->setEditorial($editorial);
        $publicacion->setEstado(EstadoDesarrollo::EnEdicion);
        try{
            $idpublicacion = $this->publicacion->postPublicacion($publicacion);
            $this->getPrevisualizarPublicacion($idpublicacion);
        }
        catch (Exception $ex){
            $data = array("error" => $ex->getMessage());
            $this->renderer->render("view/contenidista/vista-publicacion.mustache",$data);
        }
    }

    public function postEditarPublicacion(){
        $imagen = $_FILES["image"];
        $idpublicacion = $_POST["idpublicacion"];
        $publicacion = $this->publicacion->getPublicacionEditableById($idpublicacion);

        if($imagen["name"] != ""){
            $source = $_SERVER["DOCUMENT_ROOT"] . '/resources/';

            try{
                Library::deleteImage($source.$publicacion['portada']);
                $name = Library::uploadImage($imagen,$source);
            }catch(Exception $e){
                $name = $publicacion["portada"];
            }
            $publicacion["portada"] = $name;
        }

        $publicacion["nombre"] = $_POST["nombre"];

        $this->publicacion->updatePublicacion($publicacion);
        header('Location: /publicacion/PrevisualizarPublicacion?idpublicacion='."$idpublicacion");
    }

    public function getPublicacionesEnEdicion(){
        $publicaciones = $this->publicacion->getPublicacionesEnEdicion($_SESSION["usuario"]["idUsuario"]);
        if(count($publicaciones) == 0){
            $data = array("listaVacia" => "no hay publicaciones en edicion");
        }
        else{
            $keys = array_keys($publicaciones[0]);
            $data = array("publicaciones" => $publicaciones, "keys" => $keys);
        }
        $this->renderer->render("view/contenidista/publicacionesEdicion.mustache", $data);
    }


    public function getPrevisualizarPublicacion($idpub = null){
        $idpublicacion = isset($_GET["idpublicacion"])? $_GET["idpublicacion"] : $idpub;
        $publicacion = $this->publicacion->getPublicacionById($idpublicacion);
        if(empty($publicacion)){
            $data = array("publicacionNotFound" => "no se pudo previsualizar la publicacion");
        }else{
            $data = array("publicacion"=> $publicacion);
        }
        $this->renderer->render("view/contenidista/vista-publicacion.mustache", $data);
    }

    public function getVerNoticias(){
        $editorial = $_GET['ideditorial'];
        $publicacion = $_GET['publicacion'];
        $noticias = $this->noticia->getNoticiasEnProdPorEditorial($editorial);
        if(count($noticias) == 0){
            $data = array("listaVacia" => "no hay noticias en edicion");
        }else{
            $keys = array_keys($noticias[0]);
            $data = array("noticias" => $noticias, "keys" => $keys,
                    "editorial" => $editorial, "publicacion" => $publicacion);
        }
        $this->renderer->render("view/contenidista/noticiasEdicion.mustache",$data);
    }

    public function getAgregarNoticia(){
        $idnoticia = $_GET['idnoticia'];
        $publicacion = $_GET['publicacion'];
        $this->noticia->addNoticiaToPublicacion($idnoticia,$publicacion);
        header('Location: /publicacion/PrevisualizarPublicacion?idpublicacion='."$publicacion");
        exit();

    }

    public function getQuitarNoticia(){
        $idnoticia = $_GET['idnoticia'];
        $publicacion = $_GET['publicacion'];
        $this->noticia->deleteNoticiaFromPublicacion($idnoticia);
        header('Location: /publicacion/PrevisualizarPublicacion?idpublicacion='."$publicacion");
        exit();
    }

    public function getEnviarAProduccion(){
        $idpublicacion = $_GET['idpublicacion'];
        try{
            $this->publicacion->enviarAProduccion($idpublicacion);
            header('Location: /dashboard');
            exit();
        }
        catch (EntityNotFoundException $ex){
            $data = array("error" => "error al actualizar la publicacion");
            $this->renderer->render("view/dashboard.mustache", $data);
        }
    }

    public function getPublicacionesAprobadas(){
        $usuario = $_SESSION['usuario']['idUsuario'];
        $publicaciones =  $this->publicacion->getPublicacionesAprobadas($usuario);

        if(count($publicaciones) == 0){
            $data = array("listaVacia" => "no hay publicaciones aprobadas");
        }
        else{
            $keys = array_keys($publicaciones[0]);
            $data = array("publicaciones" => $publicaciones, "keys" => $keys);
        }

        $this->renderer->render("view/contenidista/publicacionesAprobadas.mustache", $data);

    }
}

