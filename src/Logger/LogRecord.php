<?php

namespace HexletPsrLinter\Logger;

use PhpParser\Node;

/**
 * Class LogItem
 * @package PsrLinter
 */
class LogRecord
{
    private $line;
    private $column;
    private $level;
    private $message;
    private $name;

    /**
     * LogItem constructor.
     * @param $line
     * @param $column
     * @param $level
     * @param $message
     * @param $name
     */
    public function __construct($line, $column, $level, $message, $name)
    {
        $this->line = $line;
        $this->column = $column;
        $this->level = $level;
        $this->message = $message;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @param mixed $line
     */
    public function setLine($line)
    {
        $this->line = $line;
    }

    /**
     * @return mixed
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param mixed $column
     */
    public function setColumn($column)
    {
        $this->column = $column;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
