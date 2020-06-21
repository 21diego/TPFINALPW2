<?php


class LogoutController
{
    public function getIndex()
    {
        session_destroy();
        header("Location: /");
        exit();
    }
}