<?php

namespace PsrLinter;

use PhpParser\Node;

class LogItem
{
    private $node;
    private $mesasge;

    /**
     * LogItem constructor.
     * @param $node
     * @param $mesasge
     */
    public function __construct($node, $mesasge)
    {
        $this->node = $node;
        $this->mesasge = $mesasge;
    }

    /**
     * @return mixed
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @param mixed $node
     */
    public function setNode($node)
    {
        $this->node = $node;
    }

    /**
     * @return mixed
     */
    public function getMesasge()
    {
        return $this->mesasge;
    }

    /**
     * @param mixed $mesasge
     */
    public function setMesasge($mesasge)
    {
        $this->mesasge = $mesasge;
    }
}
