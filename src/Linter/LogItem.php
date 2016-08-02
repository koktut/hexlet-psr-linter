<?php

namespace HexletPsrLinter\Linter;

use PhpParser\Node;

/**
 * Class LogItem
 * @package PsrLinter
 */
class LogItem
{
    const LOGLEVEL_ERROR = 1;
    const LOGLEVEL_WARNING = 2;

    private $line;
    private $level;
    private $message;
    private $name;

    /**
     * LogItem constructor.
     * @param $line
     * @param $level
     * @param $message
     * @param $name
     */
    public function __construct($line, $level, $message, $name)
    {
        $this->line = $line;
        $this->level = $level;
        $this->message = $message;
        $this->name = $name;
        
        return $this;
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
