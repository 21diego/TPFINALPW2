<?php


class Noticia {

    private $id;
    private $titulo;
    private $cuerpo;
    private $imagen;

    /**
     * Noticia constructor.
     * @param $id
     * @param $titulo
     * @param $cuerpo
     * @param $imagen
     */

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitulo() {
        return $this->titulo;
    }

    /**
     * @param mixed $titulo
     */
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    /**
     * @return mixed
     */
    public function getCuerpo() {
        return $this->cuerpo;
    }

    /**
     * @param mixed $cuerpo
     */
    public function setCuerpo($cuerpo) {
        $this->cuerpo = $cuerpo;
    }

    /**
     * @return mixed
     */
    public function getImagen() {
        return $this->imagen;
    }

    /**
     * @param mixed $imagen
     */
    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

}