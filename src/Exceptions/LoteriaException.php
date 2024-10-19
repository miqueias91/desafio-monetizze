<?php

declare(strict_types=1);

class LoteriaException extends Exception
{
    protected $field;

    public function __construct($message, $field = '', $code = 403, Exception $previous = null)
    {
        $this->field = $field;
        parent::__construct($message, $code, $previous);
    }

    public function getField()
    {
        return $this->field;
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message} para o campo '{$this->field}'";
    }
}