<?php


class EntityNotFoundException extends RuntimeException
{
    private $mensaje;
    private $sql;

    /**
     * EntityNotFoundException constructor.
     * @param str $mensaje
     * @param str $sql
     */
    public function __construct($mensaje, $sql)
    {
        $this->mensaje = $mensaje;
        $this->sql = $sql;
    }

    /**
     * @return str
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }
}