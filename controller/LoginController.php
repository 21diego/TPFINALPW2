<?php

require_once "controller/GenericController.php";

class LoginController extends GenericController
{
    private $usuario;
    private $renderer;


    /**
     * LoginController constructor.
     * @param UsuarioDAO $usuario
     * @param Renderer $renderer
     */
    public function __construct($usuario, $renderer)
    {
        $this->usuario = $usuario;
        $this->renderer = $renderer;
    }

    public function getIndex()
    {
        if ($this->existeSesion()) {
            header("Location: /dashboard");
            exit();
        }
        echo $this->renderer->render("view/login.mustache");

    }

    public function postIndex()
    {
        if ($this->existeSesion()) {
            header("Location: /dashboard");
            exit();
        }

        $nombre_mail = $_POST["email"];
        $password = md5($_POST["password"]);
        try {
            $usuario = $this->usuario->getUsuario($nombre_mail, $password);

            $_SESSION["usuario"] = Usuario::toArrayMap($usuario);

            echo $this->renderer->render("view/login-exitoso.mustache", array(
                "usuario" => Usuario::toArrayMap($usuario)
            ));
        } catch (EntityNotFoundException $ex) {
            echo $this->renderer->render("view/login.mustache", array(
                "error" => "Datos inválidos"
            ));
        }

    }
}