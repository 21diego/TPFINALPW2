<?php

include_once "controller/GenericController.php";
include_once "model/Noticia.php";
include_once  "model/EstadoNoticia.php";

class NoticiaController extends GenericController {

    private $renderer;
    private $noticia;
    private $seccion;

    /**
     * NoticiaController constructor.
     * @param Renderer $renderer
     * @param NoticiaDAO $noticia
     * @param SeccionDAO $seccion
     */
    public function __construct($renderer, $noticia,$seccion) {
        $this->renderer = $renderer;
        $this->noticia = $noticia;
        $this->seccion = $seccion;
    }

    public function getCrearNoticia(){
        $idnoticia = isset($_GET["idnoticia"]) ? $_GET["idnoticia"] : false;
        if($idnoticia == false){
            $secciones = $this->seccion->getSeccion();
            $data = array('secciones' => $secciones);
        }else{
            $noticia = $this->noticia->getNoticia($idnoticia);
            $secciones = $this->seccion->getSeccion();
            $source = $_SERVER["DOCUMENT_ROOT"] . '/resources/';
            $data = array('secciones' => $secciones, "noticia" => $noticia, "source" => $source);
        }

        $this->genericRender("view/contenidista/crear-noticia.mustache",$data,$this->renderer);
    }

    public function postCrearNoticia(){

        $source = $_SERVER["DOCUMENT_ROOT"] . '/resources/';
        $titulo = $_POST['titulo'];
        $cuerpo = $_POST['cuerpo'];
        $seccion = isset($_POST['seccion'])? $_POST['seccion'] : null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $type = '.' . explode('/',$_FILES['image']['type'])[1];
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $nombre = 'img-'.substr(str_shuffle($permitted_chars), 0, 20).$type;
            $tmpname = $_FILES['image']['tmp_name'];

            if(move_uploaded_file($tmpname,$source.$nombre)){
                $image = $nombre;
                $noticia = new Noticia();
                $noticia->setTitulo($titulo);
                $noticia->setCuerpo($cuerpo);
                $noticia->setImagen($image);
                $noticia->setSeccion($seccion);
                $noticia->setEditor($_SESSION["usuario"]["idUsuario"]);
                $noticia->setEstado(EstadoNoticia::EnEdicion);

                $this->noticia->postNoticia($noticia);
                $this->genericRender("view/dashboard.mustache",array(),$this->renderer);
            }
            else{
                $data = array("error" => "No se pudo guardar");
                $this->genericRender("view/contenidista/crear-noticia.mustache", $data,$this->renderer);
            }
        }
    }

    public function postEditarNoticia(){
        $imagen = $_FILES["image"];
        $noticia = $this->noticia->getNoticia($_POST["idnoticia"]);
        if($imagen["name"] != ""){
            $source = $_SERVER["DOCUMENT_ROOT"] . '/resources/';
            if(unlink($source.$noticia["imagenURL"])){
                $type = '.' . explode('/',$imagen['type'])[1];
                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $nombre = 'img-'.substr(str_shuffle($permitted_chars), 0, 20).$type;
                $tmpname = $imagen['tmp_name'];
                if(move_uploaded_file($tmpname,$source.$nombre)){
                    $noticia["imagenURL"] = $nombre;
                }
            }
        }
        $noticia["titulo"] = $_POST["titulo"];
        $noticia["cuerpo"] = $_POST["cuerpo"];
        $noticia["seccion"] = $_POST["seccion"];
        $this->noticia->updateNoticia($noticia);

        $data = array();
        $this->genericRender("view/dashboard.mustache",$data ,$this->renderer);
    }

    public function getNoticiasEdicion(){
        $noticias = $this->noticia->getNoticiasEnEdicion($_SESSION["usuario"]["idUsuario"]);
        if(count($noticias) == 0){
            $data = array("listaVacia" => "no hay noticias en edicion");
        }else{
            $keys = array_keys($noticias[0]);
            $data = array("noticias" => $noticias, "keys" => $keys);
        }
        $this->genericRender("view/contenidista/noticiasEdicion.mustache",$data,$this->renderer);
    }
    public function getPrevisualizarNoticia(){
        $idnoticia = $_GET["idnoticia"];
        $noticia = $this->noticia->getNoticia($idnoticia);
        if(empty($noticia)){
            $data = array("noticiaNotFound" => "no se pudo previsualizar la noticia");
        }else{
            $source = $_SERVER["DOCUMENT_ROOT"] . '/resources/';
            $data = array("noticia"=> $noticia, "source" => $source);
        }
        $this->genericRender("view/contenidista/previsualizarNoticia.mustache", $data, $this->renderer);
    }

    public function getEnviarAProduccion(){
        $idnoticia = $_GET["idnoticia"];
        $noticia = $this->noticia->getNoticia($idnoticia);
        try{
            $noticia["estado"] = EstadoNoticia::EnProduccion;

            $this->noticia->updateNoticia($noticia);
            $data = array();
        }catch (EntityNotFoundException $ex){
            $data = array("error" => "error al actualizar noticia");
        }
        $this->genericRender("view/dashboard.mustache", $data, $this->renderer);
    }
}