<?php

include_once "model/Noticia.php";
include_once "model/EstadoDesarrollo.php";
include_once "helper/Library.php";

class NoticiaController{

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

        $this->renderer->render("view/contenidista/crear-noticia.mustache",$data);
    }

    public function postCrearNoticia(){

        $source = $_SERVER["DOCUMENT_ROOT"] . '/resources/';
        $titulo = $_POST['titulo'];
        $cuerpo = $_POST['cuerpo'];
        $seccion = isset($_POST['seccion'])? $_POST['seccion'] : null;

        try{
            $name = Library::uploadImage($_FILES['image'],$source);

            $noticia = new Noticia();
            $noticia->setTitulo($titulo);
            $noticia->setCuerpo($cuerpo);
            $noticia->setImagen($name);
            $noticia->setSeccion($seccion);
            $noticia->setEditor($_SESSION["usuario"]["idUsuario"]);
            $noticia->setEstado(EstadoDesarrollo::EnEdicion);

            $this->noticia->postNoticia($noticia);
            $this->renderer->render("view/dashboard.mustache",array());
        }catch (Exception $e){
            $data = array("error" => $e->getMessage());
            $this->renderer->render("view/contenidista/crear-noticia.mustache", $data);
        }


    }

    public function postEditarNoticia(){
        $imagen = $_FILES["image"];
        $noticia = $this->noticia->getNoticia($_POST["idnoticia"]);

        if($imagen["name"] != ""){
            $source = $_SERVER["DOCUMENT_ROOT"] . '/resources/';

            try{
                Library::deleteImage($source.$noticia['imagenURL']);
                $name = Library::uploadImage($imagen,$source);
            }catch(Exception $e){
                $name = $noticia["imagenURL"];
            }
            $noticia["imagenURL"] = $name;
        }

        $noticia["titulo"] = $_POST["titulo"];
        $noticia["cuerpo"] = $_POST["cuerpo"];
        $noticia["seccion"] = $_POST["seccion"];

        $this->noticia->updateNoticia($noticia);
        $data = array();
        $this->renderer->render("view/noticiasEdicion.mustache",$data);
    }

    public function getNoticiasEdicion(){
        $noticias = $this->noticia->getNoticiasEnEdicion($_SESSION["usuario"]["idUsuario"]);
        if(count($noticias) == 0){
            $data = array("listaVacia" => "no hay noticias en edicion");
        }else{
            $keys = array_keys($noticias[0]);
            $data = array("noticias" => $noticias, "keys" => $keys);
        }
        $this->renderer->render("view/contenidista/noticiasEdicion.mustache",$data);
    }
    public function getPrevisualizarNoticia(){
        $idnoticia = $_GET["idnoticia"];
        $noticia = $this->noticia->getNoticia($idnoticia);
        if(empty($noticia)){
            $data = array("noticiaNotFound" => "no se pudo previsualizar la noticia");
        }else{
            $source = $_SERVER["DOCUMENT_ROOT"] . '/resources/';
            $editorial = isset($_GET['editorial'])?$_GET['editorial']:false;
            $publicacion = isset($_GET['publicacion'])?$_GET['publicacion']:false;
            $agregado = isset($_GET['agregado'])?$_GET['agregado']:false;
            $data = array("noticia"=> $noticia, "source" => $source,
                    "editorial" => $editorial, "publicacion"=>$publicacion,
                    "agregado"=>$agregado);
        }
        $this->renderer->render("view/contenidista/previsualizarNoticia.mustache", $data);
    }

    public function getEnviarAProduccion(){
        $idnoticia = $_GET["idnoticia"];
        $noticia = $this->noticia->getNoticia($idnoticia);
        try{
            $noticia["estado"] = EstadoDesarrollo::EnProduccion;

            $this->noticia->updateNoticia($noticia);
            $data = array();
        }catch (EntityNotFoundException $ex){
            $data = array("error" => "error al actualizar noticia");
        }
        $this->renderer->render("view/dashboard.mustache", $data);
    }

    public function getEnviarAEdicion(){
        $idnoticia = $_GET["idnoticia"];
        $noticia = $this->noticia->getNoticia($idnoticia);
        try{
            $noticia["estado"] = EstadoDesarrollo::EnEdicion;

            $this->noticia->updateNoticia($noticia);
            $data = array();
        }catch (EntityNotFoundException $ex){
            $data = array("error" => "error al actualizar noticia");
        }
        header('Location: /dashboard');
        exit();
    }

    public function getVistaPublicacion(){
        $secciones = "";
        $data = array(
            "publicacion" => array(
                    "nombre" => "",
                    "portada" => "",
                    "secciones" => $secciones
            )
        );
    }

}