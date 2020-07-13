<?php


class ReporteModel {
    private $conexion;

    /**
     * PublicacionDAO constructor.
     * @param Database $conexion
     */
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getSuscripcionesXmes($mes, $anio){
        return $this->conexion->query(
                "select se.id_usuario as 'id usuario', Concat(u.nombre,' ',u.apellido) as nombre,
               se.id_suscripcion as 'id suscripcion', s.valor, se.fechaInicio
               from se_suscribe se
               join usuario u on se.id_usuario = u.idUsuario
               join suscripcion s on se.id_suscripcion = s.idsuscripcion
               where MONTH(se.fechaInicio) = '$mes' AND YEAR(se.fechaIncio) = '$anio'"
        );
    }
    public function getSuscripcionesEntreFechas($fecha, $fecha2){
        return $this->conexion->query(
                "select se.id_usuario as 'id usuario', Concat(u.nombre,' ',u.apellido) as nombre,
               se.id_suscripcion as 'id suscripcion', s.valor, se.fechaInicio
               from se_suscribe se
               join usuario u on se.id_usuario = u.idUsuario
               join suscripcion s on se.id_suscripcion = s.idsuscripcion
               where se.fechaInicio between '$fecha' and '$fecha2'"
        );
    }
    public function getrecaudacionTotalSuscripciones(){
        return $this->conexion->querySingleRow(
                "select sum(s.valor) 
           from se_suscribe se
           join suscripcion s on se.id_suscripcion = s.idsuscripcion"
        );
    }
    public function getrecaudacionTotalSuscripcionesXmes($mes, $anio){
        $total = $this->conexion->querySingleRow(
                "select sum(s.valor) as total
           from se_suscribe se
           join suscripcion s on se.id_suscripcion = s.idsuscripcion
           where MONTH(se.fechaInicio) = '$mes' AND YEAR(se.fechaInicio) = '$anio'"
        );
        return $total['total'];
    }
    public function getrecaudacionTotalSuscripcionesEntrefechas($fecha, $fecha2){
        return $this->conexion->querySingleRow(
                "select sum(s.valor) 
           from se_suscribe se
           join suscripcion s on se.id_suscripcion = s.idsuscripcion
           where se.fechaInicio between '$fecha' and '$fecha2'"
        );
    }
    public function getcantidadTotalSuscripciones(){
        return $this->conexion->querySingleRow(
                "select count(s.idsuscripcion) 
           from se_suscribe se
           join suscripcion s on se.id_suscripcion = s.idsuscripcion"
        );
    }
    public function getcantidadTotalSuscripcionesXmes($mes, $anio){
        $cantidad = $this->conexion->querySingleRow(
                "select count(s.idsuscripcion) as cantidad
           from se_suscribe se
           join suscripcion s on se.id_suscripcion = s.idsuscripcion
           where MONTH(se.fechaInicio) = '$mes' AND YEAR(se.fechaInicio) = '$anio'"
        );
        return $cantidad['cantidad'];
    }
    public function getcantidadTotalSuscripcionesEntrefechas($fecha, $fecha2){
        return $this->conexion->querySingleRow(
                "select count(s.idsuscripcion) 
           from se_suscribe se
           join suscripcion s on se.id_suscripcion = s.idsuscripcion
           where se.fechaInicio between '$fecha' and '$fecha2'"
        );
    }
    public function getrecaudacionTotalCompras(){
        return $this->conexion->querySingleRow(
                "select sum(p.valor) 
           from compra c
           join publicacion p on c.idpublicacion = p.idpublicacion"
        );
    }
    public function getrecaudacionTotalComprasXmes($mes, $anio){
        $total = $this->conexion->querySingleRow(
                "select sum(p.valor) as total
           from compra c
           join publicacion p on c.idpublicacion = p.idpublicacion
           where MONTH(c.fechaCompra) = '$mes' and YEAR(c.fechaCompra) = '$anio'"
        );
        return $total['total'];
    }
    public function getrecaudacionTotalComprasEntreFechas($fecha, $fecha2){
        return $this->conexion->querySingleRow(
                "select sum(p.valor) 
           from compra c
           join publicacion p on c.idpublicacion = p.idpublicacion
           where c.fechaCompra between '$fecha' and '$fecha2'"
        );
    }
    public function getcantidadTotalCompras(){
        return $this->conexion->querySingleRow(
                "select count(p.idpublicacion) 
           from compra c
           join publicacion p on c.idpublicacion = p.idpublicacion"
        );
    }
    public function getcantidadTotalComprasXmes($mes, $anio){
        $cantidad = $this->conexion->querySingleRow(
                "select count(p.idpublicacion) as cantidad
           from compra c
           join publicacion p on c.idpublicacion = p.idpublicacion
           where MONTH(c.fechaCompra) = '$mes' and YEAR(c.fechaCompra) = '$anio'"
        );
        return $cantidad['cantidad'];
    }
    public function getcantidadTotalComprasEntreFechas($fecha, $fecha2){
        return $this->conexion->querySingleRow(
                "select count(p.idpublicacion) 
           from compra c
           join publicacion p on c.idpublicacion = p.idpublicacion
           where c.fechaCompra between '$fecha' and '$fecha2'"
        );
    }
}