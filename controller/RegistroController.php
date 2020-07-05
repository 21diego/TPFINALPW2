<?php

require_once "helper/Library.php";

class RegistroController
{
    private $usuarioDao;
    private $renderer;

    /**
     * RegistroController constructor.
     * @param UsuarioDAO $usuarioDao
     * @param Renderer $renderer
     */
    public function __construct($usuarioDao, $renderer)
    {
        $this->usuarioDao = $usuarioDao;
        $this->renderer = $renderer;
    }

    public function getIndex()
    {
        if (Library::existeSesion()) {
            header("Location: /dashboard");
            exit();
        }
        echo $this->renderer->render("view/registro.mustache");

    }

    public function postIndex()
    {
        if (Library::existeSesion()) {
            header("Location: /dashboard");
            exit();
        }

        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $dni = $_POST["dni"];
        $email = $_POST["email"];
        $password = md5($_POST["password"]);
        $password2 = md5($_POST["password2"]);


        if ($password !== $password2) {
            $this->renderer->render("view/registro.mustache",array(
                            "error" => "Las contraseñas no coinciden",
                            "data" => array(
                                    "nombre" => $nombre,
                                    "apellido" => $apellido,
                                    "dni" => $dni,
                                    "email" => $email
                            )));
        }

        try {
            $id_usuario = $this
                ->usuarioDao
                ->insertarUsuario($nombre, $apellido, $dni, $password, $email);
        } catch (InsertEntityException $ex) {
            $this->renderer->render("view/registro.mustache",array(
                    "error" => "Error al generar usuario",
                    "data" => array(
                            "nombre" => $nombre,
                            "apellido" => $apellido,
                            "dni" => $dni,
                            "email" => $email
                    )));
        }

        if ($email) {
            $this->renderer->render("view/registro-exito.mustache");
        } else {
            $this->renderer->render("view/registro.mustache", array(
                "error" => "Error al realizar registro",
                "data" => array(
                        "nombre" => $nombre,
                        "apellido" => $apellido,
                        "dni" => $dni,
                        "email" => $email
                )
            ));
            exit();
        }

    }
}