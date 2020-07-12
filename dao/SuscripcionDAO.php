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
            try {
               $today = Library::getTodayArg();
                $dateInicio = $today->format('Y/m/d H:i:s');
                $months = intval($suscripcion["meses"]);
                $today->modify("+".$months." months");
                $dateFin = $today->format('Y/m/d H:i:s');
                $this
                    ->conexion
                    ->insertQuery("insert into se_suscribe(id_suscripcion,id_usuario,id_editorial,fechaFin,fechaInicio)
                         values ('$idsuscripcion','$idusuario','$ideditorial','$dateFin','$dateInicio')");
            } catch (Exception $ex) {

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