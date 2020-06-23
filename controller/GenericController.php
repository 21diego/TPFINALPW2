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
    public function genericRender($vista,$data = array(),$renderer){
        if ($this->existeSesion()) {
            $rol = $_SESSION['usuario']['rol'];
            $datamerge =  array_merge($data,array("$rol"=> 'rol'));

            echo $renderer->render($vista,$datamerge);

        } else {
            header("Location: /login");
            exit();
        }
    }
}