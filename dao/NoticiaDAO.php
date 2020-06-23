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
        try{
            $this
            ->conexion
            ->insertQuery("insert into noticia(titulo,cuerpo,imagenURL)
                         values ('$titulo','$cuerpo','$imagen')");
        }
        catch (Exception $ex){

        }
    }
}