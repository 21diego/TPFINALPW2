<?php


class NoticiaDAO {

    private $conexion;

    /**
     * NoticiaDAO constructor.
     * @param Database $conexion
     */
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    /**
     * NoticiaDAO constructor.
     * @param Noticia $noticia
     */
    public function postNoticia($noticia){
        $titulo = $noticia->getTitulo();
        $cuerpo = $noticia->getCuerpo();
        $imagen = $noticia->getImagen();
        $seccion = $noticia->getSeccion();
        $editor = $noticia->getEditor();
        try{
            $this
            ->conexion
            ->insertQuery("insert into noticia(titulo,cuerpo,imagenURL,seccion,editor)
                         values ('$titulo','$cuerpo','$imagen','$seccion','$editor')");
        }
        catch (Exception $ex){

        }
    }
}