<?php
class CompraDAO{
private $conexion;

    /**
     * CompraDAO constructor.
     * @param Database $conexion
     */
    public function __construct($conexion){
    $this->conexion = $conexion;
}

    public function postCompra($idusuario, $idpublicacion){
        $today = Library::getTodayArg();
        $date = $today->format('Y/m/d H:i:s');
        return $this->conexion->insertQuery(
            "insert into compra(idusuario,idpublicacion,fechaCompra)
                values('$idusuario','$idpublicacion','$date')"
        );
    }
    public function buscarCompra($idusuario, $idpublicacion){
        return $this->conexion->querySingleRow("
            select * from compra where idusuario = '$idusuario' and idpublicacion = '$idpublicacion'
        ");
    }
}
?>