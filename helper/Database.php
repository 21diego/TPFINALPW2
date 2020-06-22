<?php

require_once('excepciones/EntityNotFoundException.php');
require_once('excepciones/InsertEntityException.php');
require_once ('excepciones/UpdateEntityException.php');

class Database
{

    private static $database = "database";

    private static $instance;
    private $conexion;



    private function __construct($servername, $username, $password, $dbname)
    {
        $this->conexion = mysqli_connect($servername, $username, $password, $dbname)
        or die("Connection failed: " . mysqli_connect_error());
    }

    /**
     * @return false|mysqli
     */
    public function getConexion() {
        return $this->conexion;
    }

    public function query($sql)
    {
        $result = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);

    }

    public function querySingleRow($sql)
    {
        $result = mysqli_query($this->conexion, $sql);
        if ($result->num_rows == 0) {
            throw new EntityNotFoundException("Entidad no encontrada", $sql);
        }

        return mysqli_fetch_assoc($result);

    }


    /**
     * @param string $sql SQL script a ejecutar
     * @return int Id generado para el script ejecutado
     */
    public function insertQuery($sql)
    {
        mysqli_query($this->conexion, $sql);

        if ($this->conexion->affected_rows <= 0) {
            throw new InsertEntityException("No se pudo insertar entidad", $sql);
        }
        return $this->conexion->insert_id;
    }

    /**
     * @param string $sql SQL script a ejecutar
     * @return int Id generado para el script ejecutado
     */
    public function updateQuery($sql){
        mysqli_query($this->conexion,$sql);
        if ($this->conexion->affected_rows < 0) {
            throw new UpdateEntityException("No se pudo actualizar entidad", $sql);
        }
        else if($this->conexion->affected_rows == 0){
            throw new SameDataUpdateException("Se setearon los mismos valores", $sql);
        }
        return $this->conexion->insert_id;
    }

    public function deleteQuery($sql)
    {
        mysqli_query($this->conexion, $sql);
        return $this->conexion->insert_id;
    }

    public function __destruct()
    {
        mysqli_close($this->conexion);
    }

    public static function getInstance(Config $config)
    {

        if (!self::$instance instanceof self) {
            self::$instance = new Database(
                $config->get(self::$database, "servername"),
                $config->get(self::$database, "username"),
                $config->get(self::$database, "password"),
                $config->get(self::$database, "dbname")
            );
        }

        return self::$instance;
    }
}