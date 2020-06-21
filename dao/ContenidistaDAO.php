<?php


class ContenidistaDAO {

    private $conexion;

    /**
     * ContenidistaDAO constructor.
     * @param Database $conexion
     */
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function postContenidista($idusuario,$ideditorial){
        return $this
                ->conexion
                ->insertQuery("insert into contenidista(idUsuario,editorial)
                                 values ($idusuario,$ideditorial)");
    }


}