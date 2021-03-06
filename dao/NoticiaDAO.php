<?php

require_once "model/EstadoDesarrollo.php";

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
        $estado = $noticia->getEstado();
        try{
            $this
            ->conexion
            ->insertQuery("insert into noticia(titulo,cuerpo,imagenURL,seccion,editor,estado)
                         values ('$titulo','$cuerpo','$imagen','$seccion','$editor','$estado')");
        }
        catch (Exception $ex){

        }

    }

    public function getNoticiasEnEdicion($editor){
        $noticias = $this
                    ->conexion
                    ->query("select n.idnoticia, n.titulo, s.nombre, n.estado
                                    from noticia n
                                    join seccion s on n.seccion = s.idseccion
                                    where editor = '$editor' and estado = 'enEdicion'");
        return $noticias;
    }

    public function getNoticiasEnProdPorEditorial($editorial){
        return $this
                ->conexion
                ->query("select n.idnoticia, n.titulo, u.nombre, u.apellido
                                from noticia n
                                join contenidista c on n.editor = c.idUsuario
                                join usuario u on u.idUsuario = c.idUsuario
                                where c.editorial = '$editorial' and estado = 'enProduccion'");
    }

    public function getNoticia($idNoticia){
        $noticia = $this
                  ->conexion
                  ->querySingleRow("select n.idnoticia, n.titulo, n.cuerpo, n.imagenURL, 
                    n.enlace, n.editor as ideditor, Concat(u.apellido,', ',u.nombre) as editor,
                    n.seccion, n.publicacion, n.estado
                  from noticia n 
                    inner join usuario as u on u.idusuario = n.editor
                  where idnoticia = '$idNoticia'");

        return $noticia;
    }

    public function addNoticiaToPublicacion($idnoticia,$idpublicacion){
        $estado = EstadoDesarrollo::Publicado;
        $this->conexion
                ->updateQuery("update noticia
                                    set publicacion = '$idpublicacion'
                                    ,estado = '$estado'
                                    where idnoticia = '$idnoticia'");
    }

    public function deleteNoticiaFromPublicacion($idnoticia){
        $estado = EstadoDesarrollo::EnProduccion;
        $this->conexion
                ->updateQuery("update noticia
                                    set publicacion = NULL
                                    ,estado = '$estado'
                                    where idnoticia = '$idnoticia'");
    }

    public function updateNoticia($noticia){
        $idnoticia = $noticia["idnoticia"];
        $titulo = $noticia['titulo'];
        $cuerpo = $noticia['cuerpo'];
        $imagen = $noticia['imagenURL'];
        $editor = $noticia['editor'];
        $seccion = $noticia['seccion'];
        $estado = $noticia['estado'];
        $this
            ->conexion
            ->updateQuery("update noticia
                            set titulo = '$titulo'
                            , cuerpo = '$cuerpo'
                            , imagenURL = '$imagen'
                            , editor = '$editor'
                            , seccion = '$seccion'
                            , estado = '$estado'
                             where idnoticia = '$idnoticia'");
    }
}