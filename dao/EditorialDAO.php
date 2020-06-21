<?php


class EditorialDAO {

    private $conexion;

    /**
     * EditorialDAO constructor.
     * @param Database $database
     */
    public function __construct($database) {
        $this->conexion = $database;
    }

    public function getEditorial($cuit){
        $editorial = $this
                ->conexion
                ->querySingleRow("select ed.ideditorial 
                                from editorial ed
                                where cuit = $cuit");

        return $editorial;

    }


}