<?php


class CannotMoveFileException extends RuntimeException {
    private $message;
    /**
     * CannotMoveFileException constructor.
     */
    public function __construct($message) {
        $this->message = $message;
    }
}