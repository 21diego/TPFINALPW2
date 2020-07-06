<?php


class Publicacion {

    private $id;
    private $nombre;
    private $numero;
    private $categoria;
    private $valor;
    private $portada;
    private $adminPublicador;
    private $contenidistaEditor;
    private $editorial;
    private $estado;

    /**
     * @return mixed
     */
    public function getEstado() {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado) {
        $this->estado = $estado;
    }

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
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getNumero() {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero) {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getCategoria() {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     */
    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    /**
     * @return mixed
     */
    public function getValor() {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor) {
        $this->valor = $valor;
    }

    /**
     * @return mixed
     */
    public function getPortada() {
        return $this->portada;
    }

    /**
     * @param mixed $portada
     */
    public function setPortada($portada) {
        $this->portada = $portada;
    }

    /**
     * @return mixed
     */
    public function getAdminPublicador() {
        return $this->adminPublicador;
    }

    /**
     * @param mixed $adminPublicador
     */
    public function setAdminPublicador($adminPublicador) {
        $this->adminPublicador = $adminPublicador;
    }

    /**
     * @return mixed
     */
    public function getContenidistaEditor() {
        return $this->contenidistaEditor;
    }

    /**
     * @param mixed $contenidistaEditor
     */
    public function setContenidistaEditor($contenidistaEditor) {
        $this->contenidistaEditor = $contenidistaEditor;
    }

    /**
     * @return mixed
     */
    public function getEditorial() {
        return $this->editorial;
    }

    /**
     * @param mixed $editorial
     */
    public function setEditorial($editorial) {
        $this->editorial = $editorial;
    }

}
