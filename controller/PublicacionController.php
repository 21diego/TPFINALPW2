<?php

require_once "controller/GenericController.php";
require_once "model/Publicacion.php";

class PublicacionController extends GenericController {

    private $renderer;
    private $publicacion;
    private $contenidista;

    /**
     * PublicacionController constructor.
     * @param Renderer $renderer
     * @param PublicacionDAO $publicacion
     * @param ContenidistaDAO $contenidista
     */
    public function __construct($renderer,$publicacion,$contenidista) {
        $this->renderer = $renderer;
        $this->publicacion = $publicacion;
        $this->contenidista = $contenidista;
    }

    public function getCrearPublicacion(){
        $data = array("comienzo" =>"start");
        $this->genericRender("view/contenidista/crear-publicacion.mustache",$data,$this->renderer);
    }

    public function postCrearPublicacion() {
        $data = array('paso2' => "2");
        $nombre = $_POST['nombre'];
        $imagen = $this->subirImagen('portada');

        $query = $this->contenidista->getMiEditorial($_SESSION['usuario']['idUsuario']);
        $contenidista = $query['idUsuario'];
        $editorial = $query["editorial"];

        $publicacion = new Publicacion();
        $publicacion->setNombre($nombre);
        $publicacion->setPortada($imagen);
        $publicacion->setContenidistaEditor($contenidista);
        $publicacion->setEditorial($editorial);

        $this->publicacion->postPublicacion($publicacion);

        $this->genericRender("view/contenidista/crear-publicacion.mustache", $data, $this->renderer);

    }

    public function subirImagen($imagen){

        if (isset($_FILES[$imagen]) && $_FILES[$imagen]['error'] === UPLOAD_ERR_OK) {
            $type = '.' . explode('/',$_FILES[$imagen]['type'])[1];
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $nombre = 'portada-'.substr(str_shuffle($permitted_chars), 0, 20).$type;
            $tmpname = $_FILES[$imagen]['tmp_name'];
            $source = $_SERVER["DOCUMENT_ROOT"] . '/resources/';

            if(move_uploaded_file($tmpname,$source.$nombre)){
                return $nombre;
            }
            return null;
        }
    }
    public function getListaNoticiasEnProduccion(){
        $result = $this->publicacion->getPublicacionById('14');

        /*Array ( [0] => Array (
                [nombre] => La mejor
                [editorial] => 1
                [portada] => img-portada
                [seccion] => economia
                [titulo] => PERON )
                [1] => Array (
                [nombre] => La mejor
                [editorial] => 1
                [portada] => img-portada
                [seccion] => economia
                [titulo] => MACRI ))*/

        $data = array (
           "nombre" => $result[0]['nombre'],
            "portada" => $result[0]['portada'],
        );
        $keys = array();
        $secciones = array();
        $secciontmp = $result[0]['seccion'];

        if(!empty($secciontmp)){
            $dataseccion = array();
            $noticias = array();
            foreach ($result as $registro){
                if($registro['seccion'] == $secciontmp){
                    $noticia = $registro['titulo'];
                    array_push($noticias,$noticia);
                }
                else{
                    array_push($secciones,$dataseccion);
                    array_push($keys,$secciontmp);
                    $secciontmp = $registro['seccion'];
                    $dataseccion = array();
                    $noticia = $registro['titulo'];
                    $dataseccion[$noticia] = $noticia;
                }
            }
            array_push($secciones,$dataseccion);
            array_push($keys,$secciontmp);
        }

        $data["secciones"] = $secciones;
        $data["keys"] = $keys;
        var_dump($data);
        $this->genericRender("view/contenidista/vista-publicacion.mustache", $data, $this->renderer);
    }

}