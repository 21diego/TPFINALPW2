<?php
include_once ("model/Rol.php");
 class ReporteModel{
     private $conexion;

     /**
      * ReporteModel constructor.
      * @param Database $conexion
      */
     public function __construct($conexion){
         $this->conexion = $conexion;
     }

     public function getSuscripcionesXmes($mes, $anio){
        return $this->conexion->query(
            "select se.id_usuario as 'id usuario', Concat(u.nombre,' ',u.apellido) as nombre,
                    se.id_suscripcion as 'id suscripcion', s.valor, se.fechaInicio
                    from se_suscribe se
                    join usuario u on se.id_usuario = u.idUsuario
                    join suscripcion s on se.id_suscripcion = s.idsuscripcion
                    where MONTH(se.fechaInicio) = '$mes' AND YEAR(se.fechaInicio) = '$anio'"
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
         $recaudacion = $this->conexion->querySingleRow(
             "select sum(s.valor) as recaudacion 
                from se_suscribe se
                join suscripcion s on se.id_suscripcion = s.idsuscripcion"
         );
         return $recaudacion["recaudacion"];
     }

     public function getrecaudacionTotalSuscripcionesXmes($mes, $anio){
         $recaudacion = $this->conexion->querySingleRow(
             "select sum(s.valor) as recaudacion
                from se_suscribe se
                join suscripcion s on se.id_suscripcion = s.idsuscripcion
                where MONTH(se.fechaInicio) = '$mes' AND YEAR(se.fechaInicio) = '$anio'"
         );
         return $recaudacion["recaudacion"];
     }
     public function getrecaudacionTotalSuscripcionesEntrefechas($fecha, $fecha2){
         $recaudacion=  $this->conexion->querySingleRow(
             "select sum(s.valor) as recaudacion
                from se_suscribe se
                join suscripcion s on se.id_suscripcion = s.idsuscripcion
                where se.fechaInicio between '$fecha' and '$fecha2'"
         );
         return $recaudacion["recaudacion"];
     }

     public function getcantidadTotalSuscripciones(){
         $cantidad=  $this->conexion->querySingleRow(
             "select count(s.idsuscripcion) as cantidad
                from se_suscribe se
                join suscripcion s on se.id_suscripcion = s.idsuscripcion"
         );
         return $cantidad["cantidad"];
     }

     public function getcantidadTotalSuscripcionesXmes($mes, $anio){
         $cantidad = $this->conexion->querySingleRow(
             "select count(s.idsuscripcion) as cantidad 
                from se_suscribe se
                join suscripcion s on se.id_suscripcion = s.idsuscripcion
                where MONTH(se.fechaInicio) = '$mes' AND YEAR(se.fechaInicio) = '$anio'"
         );
         return $cantidad["cantidad"];
     }
     public function getcantidadTotalSuscripcionesEntrefechas($fecha, $fecha2){
         $cantidad = $this->conexion->querySingleRow(
             "select cout(s.idsuscripcion) as cantidad
                from se_suscribe se
                join suscripcion s on se.id_suscripcion = s.idsuscripcion
                where se.fechaInicio between '$fecha' and '$fecha2'"
         );
         return $cantidad["cantidad"];
     }

     public function getrecaudacionTotalCompras(){
         $recaudacion = $this->conexion->querySingleRow(
             "select sum(p.valor) as recaudacion
                from compra c
                join publicacion p on c.idpublicacion = p.idpublicacion"
         );
         return $recaudacion["recaudacion"];
     }
     public function getrecaudacionTotalComprasXmes($mes, $anio){
         $recaudacion = $this->conexion->querySingleRow(
             "select sum(p.valor) as recaudacion
                from compra c
                join publicacion p on c.idpublicacion = p.idpublicacion
                where MONTH(c.fechaCompra) = '$mes' and YEAR(c.fechaCompra) = '$anio'"
         );
         return $recaudacion["recaudacion"];
     }

     public function getrecaudacionTotalComprasEntreFechas($fecha, $fecha2){
         $recaudacion = $this->conexion->querySingleRow(
             "select sum(p.valor) as recaudacion
                from compra c
                join publicacion p on c.idpublicacion = p.idpublicacion
                where c.fechaCompra between '$fecha' and '$fecha2'"
         );
         return $recaudacion["recaudacion"];
     }

     public function getcantidadTotalCompras(){
         $cantidad = $this->conexion->querySingleRow(
             "select count(p.idpublicacion) as cantidad
                from compra c
                join publicacion p on c.idpublicacion = p.idpublicacion"
         );
         return $cantidad["cantidad"];
     }
     public function getcantidadTotalComprasXmes($mes, $anio){
         $cantidad = $this->conexion->querySingleRow(
             "select count(p.idpublicacion) as cantidad
                from compra c
                join publicacion p on c.idpublicacion = p.idpublicacion
                where MONTH(c.fechaCompra) = '$mes' and YEAR(c.fechaCompra) = '$anio'"
         );
         return $cantidad["cantidad"];
     }

     public function getcantidadTotalComprasEntreFechas($fecha, $fecha2){
         $cantidad = $this->conexion->querySingleRow(
             "select count(p.idpublicacion) as cantidad
                from compra c
                join publicacion p on c.idpublicacion = p.idpublicacion
                where c.fechaCompra between '$fecha' and '$fecha2'"
         );
         return $cantidad["cantidad"];
     }

     public function getCantidadDeUsuariosPagos(){
         $usuarios = $this->conexion->querySingleRow(
             "select count(u.idUsuario) as usuarios from usuario u
            where u.idUsuario in(
            select se.id_usuario
            from se_suscribe se
         )  or u.idUsuario in (
            select c.idusuario from compra c
            )"
         );
         return $usuarios["usuarios"];
     }

     public function getCantidadDeUsuariosGratuitos(){
         $usuarios = $this->conexion->querySingleRow(
             "select count(u.idUsuario) as usuarios from usuario u
            where u.idUsuario not in(
            select se.id_usuario
            from se_suscribe se
         )  and u.idUsuario not in (
            select c.idusuario from compra c
            )"
         );
         return $usuarios["usuarios"];
     }

     public function getCantPublicacionesXEditorial(){
        $editoriales = $this->conexion->query(
          "select e.razonSocial, count(p.idpublicacion) as publicacion from editorial e 
                join publicacion p on e.ideditorial = p.editorial
                group by e.ideditorial"
        );
        return $editoriales;
     }
 }
?>

