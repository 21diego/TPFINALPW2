<?php
    class SeccionDAO{
        private $conexion;

        /**
         * EditorialDAO constructor.
         * @param Database $database
         */
        public function __construct($database) {
            $this->conexion = $database;
        }

        public function getSeccion(){
          $seccion = $this
                      ->conexion
                      ->query("select s.idseccion, s.nombre
                                    from seccion s");
          return $seccion;
    }


    }
?>