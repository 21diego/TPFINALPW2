<?php
class suscripcionDAO{
    private $conexion;

    /**
 * suscripcionDAO constructor.
     * @param Database $database
 */
    public function __construct($database){
    $this->conexion = $database;
}

public function getSuscripciones(){
        $suscripciones = $this->conexion
            ->query("select * from suscripcion");
        return $suscripciones;
}

public function getSuscripcionById($idsuscripcion){
        $suscripcion = $this->conexion
            ->querySingleRow("select * from suscripcion
                                where idsuscripcion = '$idsuscripcion'");
        return $suscripcion;
}

 public function suscribirse($idusuario, $idsuscripcion, $ideditorial){
    $suscripcion = $this->getSuscripcionById($idsuscripcion);
    if(!empty($suscripcion)){
        $hoy = getdate();
        $d= $hoy["mday"];
        $m = $hoy["month"];
        $y = $hoy["year"];
        if($suscripcion["meses"] != 0){
            $m += $suscripcion["meses"];
            $date = $y."/".$m."/".$d;
            try{
                $this
                    ->conexion
                    ->insertQuery("insert into se_suscribe(id_suscripcion,id_usuario,id_editorial,fechaFin)
                         values ('$idsuscripcion','$idusuario','$ideditorial','$date')");
            }
            catch (Exception $ex){

            }
        }
    }
}

public function getSuscripcionesByUsuario($idusuario){
        $suscriciones = $this->conexion->query(
            "select se.fechaFin, e.razonsocial from se_suscribe se 
                    inner join editorial e 
                    on se.id_editorial = e.ideditorial
                    where id_usuario = '$idusuario'"
        );
        return $suscriciones;
}
public function buscarSuscripcion($idusuario, $ideditorial){
        $suscripcion = $this->conexion->querySingleRow(
            "select * from se_suscribe
                    where id_usuario = '$idusuario' and id_editorial = '$ideditorial'"
        );
        return $suscripcion;
}

}
?>