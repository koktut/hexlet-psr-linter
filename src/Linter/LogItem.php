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
    private $message;
    private $level;

    /**
     * LogItem constructor.
     * @param $node
     * @param $message
     * @param $level
     * @internal param $mesasge
     */
    public function __construct($node, $message, $level)
    {
        $this->line = $node;
        $this->message = $message;
        $this->level = $level;
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
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $message
     * @internal param mixed $mesasge
     */
    public function setMessage($message)
    {
        $this->message = $message;
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
}
