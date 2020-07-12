<?php


class PublicacionDAO {

    private $conexion;

    /**
     * PublicacionDAO constructor.
     * @param Database $conexion
     */
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getPublicaciones(){
        return $this->conexion->query(
            "select p.*, e.razonsocial from publicacion p
                    join editorial e on p.editorial = e.ideditorial"
        );
    }

    public function getPublicacionById($id){
        return $this->conexion->query("select p.nombre,p.editorial,p.portada,s.nombre as seccion,n.titulo
                                    from publicacion p
                                    join noticia n on n.publicacion = p.idpublicacion
                                    join seccion s on n.seccion = s.idseccion
                                    where idpublicacion = '$id'
                                    order by s.nombre");
    }

    public function getpublicacionId($id){
        return $this->conexion->querySingleRow("select * from publicacion where idpublicacion = '$id'");
    }

    public function getPublicacionByEditorial($idEditorial){

    }

    /**
     * @param Publicacion $publicacion
     */
    public function postPublicacion($publicacion){
        $nombre = $publicacion->getNombre()?$publicacion->getNombre():null;
        $numero = $publicacion->getNumero()? $publicacion->getNumero():null;
        $categoria = $publicacion->getCategoria()? $publicacion->getCategoria():null;
        $valor = $publicacion->getValor()? $publicacion->getValor():null;
        $portada = $publicacion->getPortada()? $publicacion->getPortada():null;
        $contenidistaEditor = $publicacion->getContenidistaEditor()?$publicacion->getContenidistaEditor() :null;
        $editorial = $publicacion->getEditorial()? $publicacion->getEditorial():null;
        try {
            $this
            ->conexion
            ->insertQuery("insert into publicacion(nombre,numero,categoria,valor,portada,contenidistaEditor,editorial)
                         values ('$nombre','$numero','$categoria','$valor','$portada','$contenidistaEditor','$editorial')");
        }
        catch (Exception $ex){
            echo $ex;
        }
    }

    public function updatePublicacion(){

    }


}