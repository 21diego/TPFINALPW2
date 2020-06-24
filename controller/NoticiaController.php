<?php

include_once "controller/GenericController.php";
include_once "model/Noticia.php";

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
        $secciones = $this->seccion->getSeccion();
        $data = array('secciones' => $secciones);
        $this->genericRender("view/contenidista/crear-noticia.mustache",$data,$this->renderer);
    }

    public function postCrearNoticia(){
        $source = $_SERVER["DOCUMENT_ROOT"] . '/resources/';
        $titulo = $_POST['titulo'];
        $cuerpo = $_POST['cuerpo'];
        $seccion = isset($_POST['seccion'])? $_POST['seccion'] : null;
        echo $seccion;
        echo $_SESSION["usuario"]["idUsuario"];

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

                $this->noticia->postNoticia($noticia);
                $this->genericRender("view/dashboard.mustache",array(),$this->renderer);
            }
            else{
                $data = array("error" => "No se pudo guardar");
                $this->genericRender("view/contenidista/crear-noticia.mustache", $data,$this->renderer);
            }
        }

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