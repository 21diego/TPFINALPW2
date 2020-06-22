<?php

require_once "model/Usuario.php";
require_once "model/Rol.php";

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
        $rol = Rol::Usuario;
        return $this
            ->conexion
            ->insertQuery("insert into usuario (nombre, apellido, dni, password, mail, rol)
                                values ('$nombre','$apellido', $dni,'$password', '$mail', '$rol')");
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
            ->querySingleRow("select us.idUsuario, us.nombre, us.apellido ,us.dni, us.mail, us.rol 
                                    from usuario us
                                    where mail = '$mail' and password = '$password'");

        return new Usuario(
            $usuario["idUsuario"],
            $usuario["nombre"],
            $usuario["apellido"],
            $usuario["dni"],
            $usuario["mail"],
            $usuario['rol']);
    }

    public function updateUsuario($usuario){
        $nombre = $usuario['nombre'];
        $apellido = $usuario['apellido'];
        $dni = $usuario['dni'];
        $mail = $usuario['mail'];
        $rol= $usuario['rol'];
        $id = $usuario['id'];
        $this
        ->conexion
        ->updateQuery("update usuario
                            set nombre = '$nombre'
                            , apellido = '$apellido'
                            , dni = $dni
                            , mail = '$mail'
                            , rol = '$rol'
                             where idUsuario = $id");


    }
}