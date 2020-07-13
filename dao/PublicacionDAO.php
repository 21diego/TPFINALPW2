<?php

require_once "model/EstadoDesarrollo.php";

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
        $estado = EstadoDesarrollo::Publicado;
        return $this
                ->conexion
                ->query("select p.*, e.razonsocial 
                            from publicacion p
                            join editorial e on p.editorial = e.ideditorial
                            where p.estado ='$estado'");
    }
    public function getPublicacionEditableById($id){
        return $this
                ->conexion
                ->querySingleRow("select p.idpublicacion, p.nombre, p.portada
                            from publicacion p
                            where p.idpublicacion = '$id'");

    }

    public function getPublicacionById($id){
        $publicacionraw = $this->conexion->query("select p.idpublicacion,p.nombre,p.editorial,e.razonsocial,p.portada,s.nombre as seccion,n.idnoticia,n.titulo
                                    from publicacion p
                                    left join noticia n on n.publicacion = p.idpublicacion
                                    left join seccion s on n.seccion = s.idseccion
                                    left join editorial e on p.editorial = e.ideditorial
                                    where idpublicacion = '$id'
                                    order by s.nombre");

        return $this->getPublicacion($publicacionraw);
    }


    public function getPublicacion($raw){
        $publicacion = array(
                "idpublicacion"=>$raw[0]['idpublicacion'],
                "nombre"=> $raw[0]['nombre'],
                "editorial"=> $raw[0]['editorial'],
                "razonsocial" => $raw[0]['razonsocial'],
                "portada"=> $raw[0]['portada']
        );

        $secciontmp = $raw[0]['seccion'];
        if(!empty($secciontmp)){
            $publicacion['secciones'] = array();
            $seccionwrap = array();
            foreach ($raw as $regitro){
                $titulo = $regitro['titulo'];
                $id = $regitro['idnoticia'];
                if($regitro['seccion'] == $secciontmp){
                    array_push($seccionwrap,array(
                            'id' => $id,
                            'titulo'=> $titulo
                    ));
                }else{
                    array_push($publicacion['secciones'],array(
                            'seccion' => $secciontmp,
                            'noticias' => $seccionwrap
                    ));
                    $secciontmp = $regitro['seccion'];
                    $seccionwrap = array();
                    array_push($seccionwrap,array(
                            'id' => $id,
                            'titulo'=> $titulo
                    ));
                }
            }
            array_push($publicacion['secciones'],array(
                    'seccion' => $secciontmp,
                    'noticias' => $seccionwrap
            ));
        }
        return $publicacion;
    }

    public function getpublicacionId($id){
        return $this->conexion->querySingleRow("select * from publicacion where idpublicacion = '$id'");
    }

    public function getPublicacionByEditorial($idEditorial){

    }

    public function getPublicacionesEnEdicion($editor){
        return $this
                ->conexion
                ->query("select p.idpublicacion, p.nombre, p.estado
                                from publicacion p
                                where contenidistaEditor = '$editor' and estado = 'enEdicion'");
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
        $estado = $publicacion->getEstado()? $publicacion->getEstado():null;
        try {
            $id = $this
            ->conexion
            ->insertQuery("insert into publicacion(nombre,numero,categoria,valor,portada,contenidistaEditor,editorial,estado)
                         values ('$nombre','$numero','$categoria','$valor','$portada','$contenidistaEditor','$editorial','$estado')");
        }
        catch (Exception $ex){
            echo $ex;
        }
        return $id;
    }

    public function updatePublicacion($publicacion){
        $id = $publicacion['idpublicacion'];
        $nombre = $publicacion['nombre'];
        $portada = $publicacion['portada'];
        $this
                ->conexion
                ->updateQuery("update publicacion
                            set nombre = '$nombre'
                            , portada = '$portada'
                             where idpublicacion = '$id'");
    }

    public function enviarAProduccion($idpublicacion){
        $estado = EstadoDesarrollo::EnProduccion;
        $this->conexion
                ->updateQuery("update publicacion
                             set estado = '$estado'
                             where idpublicacion = '$idpublicacion'");
    }

    public function getPublicacionesPendiente(){
        $estado = EstadoDesarrollo::EnProduccion;
        return $this
                ->conexion
                ->query("select p.idpublicacion, p.nombre, p.numero, 
                                p.valor, e.razonsocial as editorial, p.estado
                            from publicacion p
                            join editorial e on e.ideditorial = p.editorial
                            where estado = '$estado'");
    }


    public function aprobar($idpublicacion){
        $estado = EstadoDesarrollo::Publicado;
        $this->conexion
                ->updateQuery("update publicacion
                             set estado = '$estado'
                             where idpublicacion = '$idpublicacion'");
    }

    public function rechazar($idpublicacion){
        $estado = EstadoDesarrollo::EnEdicion;
        $this->conexion
                ->updateQuery("update publicacion
                             set estado = '$estado'
                             where idpublicacion = '$idpublicacion'");
    }

    public function getPublicacionesAprobadas($usuario){
        $estado = EstadoDesarrollo::Publicado;
        return $this
                ->conexion
                ->query("select p.idpublicacion, p.portada, p.nombre, p.numero, 
                                p.valor, e.razonsocial as editorial, p.estado
                            from publicacion p
                            join editorial e on e.ideditorial = p.editorial
                            where estado = '$estado'");
    }

    public function getPublicacionesGratuitas(){
        $publicaciones = $this->conexion->query(
            "select p.nombre as Publicacion, e.razonSocial as Editorial from publicacion p 
                    join editorial e on p.editorial = e.ideditorial
                    where p.valor =  0"
        );
        return $publicaciones;
    }


}