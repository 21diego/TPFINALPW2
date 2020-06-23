<?php


class GenericController
{

    /**
     * @return bool
     */
    public function existeSesion() {
        return !empty($_SESSION);
    }

    /**
     * @param string $vista
     */
    public function verficarUsuario($vista,$data = array(),$renderer){
        if ($this->existeSesion()) {
            echo $renderer->render($vista,$data);

        } else {
            header("Location: /login");
            exit();
        }
    }
}