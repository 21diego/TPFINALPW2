<?php


class Usuario
{

    private $id;
    private $nombre;
    private $apellido;
    private $dni;
    private $mail;
    private $rol;

    /**
     * Usuario constructor.
     * @param int $id
     * @param string $nombre
     * @param string $apellido
     * @param int $dni
     * @param string $mail
     * @param string $rol
     */
    public function __construct($id, $nombre, $apellido, $dni, $mail, $rol) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->dni = $dni;
        $this->mail = $mail;
        $this->rol = $rol;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getApellido() {
        return $this->apellido;
    }

    /**
     * @param string $apellido
     */
    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    /**
     * @return int
     */
    public function getDni() {
        return $this->dni;
    }

    /**
     * @param int $dni
     */
    public function setDni($dni) {
        $this->dni = $dni;
    }

    /**
     * @return string
     */
    public function getMail() {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail($mail) {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getRol() {
        return $this->rol;
    }

    /**
     * @param string $rol
     */
    public function setRol($rol) {
        $this->rol = $rol;
    }



    /**
     * @param Usuario $usuario
     *
     * @return array
     */
    public static function toArrayMap($usuario)
    {
        if (isset($usuario)) {
            return array(
                "id" => $usuario->getId(),
                "mail" => $usuario->getMail(),
                "apellido" => $usuario->getApellido(),
                "nombre" => $usuario->getNombre(),
                "dni" => $usuario->getDni(),
                "rol" => $usuario->getRol(),
            );
        } else {
            return array();
        }
    }


}