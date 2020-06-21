<?php


class PersonaDAO
{
    private $conexion;

    /**
     * PersonaDAO constructor.
     * @param Database $database
     */
    public function __construct($database)
    {
        $this->conexion = $database;
    }

    public function insertarPersona($apellido, $nombres, $fecha_nacimiento)
    {
        return $this
            ->conexion
            ->insertQuery("insert into persona (apellido, nombres, fecha_nacimiento) value ('$apellido', '$nombres', STR_TO_DATE('$fecha_nacimiento', '%Y-%m-%d'))");
    }

    public function borrarPersona($id_persona)
    {
        return $this
            ->conexion
            ->deleteQuery("delete from persona where id = $id_persona limit 1");
    }
}