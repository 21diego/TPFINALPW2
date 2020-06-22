<?php

require_once 'excepciones/EntityNotFoundException.php';
require_once 'excepciones/AlreadyRequestException.php';

class ContenidistaDAO {

    private $conexion;

    /**
     * ContenidistaDAO constructor.
     * @param Database $conexion
     */
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getContenidistaByUsuario($idUsuario){
        return $this
                ->conexion
                ->querySingleRow("select c.idcontenidista, c.idUsuario, c.editorial 
                                from contenidista c where idUsuario = $idUsuario");
    }

    public function postContenidista($idusuario,$ideditorial){
        try{
            $this
            ->conexion
            ->querySingleRow("select c.idcontenidista, c.idUsuario, c.editorial 
                        from contenidista c 
                        where idUsuario = $idusuario and editorial = $ideditorial");
        }
        catch (EntityNotFoundException $ex){
            return $this
                    ->conexion
                    ->insertQuery("insert into contenidista(idUsuario,editorial)
                                 values ($idusuario,$ideditorial)");
        }
        throw new AlreadyRequestException("Ya se envió una solicitud");

    }


}