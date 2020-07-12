<?php
    class ValidarPagoForm{

        public static function validarNroTarjeta($nro){
             if(strlen($nro) == 16){
                 return true;
             }else{
                 return false;
             }
         }

        public static function validarDni($dni){
            if(strlen($dni) == 8){
                return true;
            }else{
                return false;
            }
        }

        public static function validarCodigoSeguridad($codigo){
            if(strlen($codigo) == 3 || strlen($codigo) == 4){
                return true;
            }else{
                return false;
            }
        }
    }
?>