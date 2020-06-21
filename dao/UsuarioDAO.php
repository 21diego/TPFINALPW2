<?php

require_once "model/Usuario.php";

class UsuarioDAO
{
    private $conexion;

    /**
     * UsuarioDAO constructor.
     * @param Database $database
     */
    public function __construct($database)
    {
        $this->conexion = $database;
    }

    public function insertarUsuario($nombre, $apellido, $dni, $password, $mail)
    {
        return $this
            ->conexion
            ->insertQuery("insert into usuario (nombre, apellido, dni, mail, password)
                                value ($nombre, $apellido, $dni, $password, $mail)");
    }

    /**
     * @param string $usuario
     * @param string $password
     *
     * @return Usuario usuario
     */
    public function getUsuario($mail, $password)
    {
        $usuario = $this
            ->conexion
            ->querySingleRow("select us.idUsuario, us.nombre, us.apellido ,us.dni, us.mail 
                                    from usuario us
                                    where mail = '$mail' and password = '$password'");

        return new Usuario(
            $usuario["idUsuario"],
            $usuario["mail"],
            $usuario["nombre"],
            $usuario["apellido"],
            date($usuario["dni"]));
    }
}