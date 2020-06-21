<?php


class GenericController
{

    /**
     * @return bool
     */
    public function existeSesion() {
        return !empty($_SESSION);
    }

}