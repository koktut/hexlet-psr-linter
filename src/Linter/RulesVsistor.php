<?php

namespace HexletPsrLinter\Linter;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Stmt;
use HexletPsrLinter\Logger\Logger;
use PhpParser\PrettyPrinter;

/**
 * Class RulesVsistor
 */
class RulesVsistor extends NodeVisitorAbstract
{
    private $rules;
    private $autoFix;
    private $log;

    /**
     * RulesVsistor constructor.
     * @param $rules
     * @param $autoFix
     */
    public function __construct($rules, $autoFix)
    {
        $this->rules = $rules;
        $this->autoFix = $autoFix;
        $this->log = [];
    }

    /**
     * @param Node $node
     * @return null|Node|void
     */
    public function enterNode(Node $node)
    {
        foreach ($this->rules as $rule) {
            $vaildator = new $rule;

            $result = $vaildator->validate($node);

            if ($result !== true) {
                list($level, $message) = $result;
                $name = $node->name;

                if ($this->autoFix) {
                    $fixedNode = $vaildator->fix($node);
                    $resultOfFix = $vaildator->validate($fixedNode);
                    if ($resultOfFix === true) {
                        $level = Logger::LOGLEVEL_FIXED;
                        $name = $name . ' -> ' . $fixedNode->name;
                        $node = $fixedNode;
                    }
                }
                $this->log[] = [
                    'line' => $node->getAttribute('startLine'),
                    'column' => 0,
                    'level' => $level,
                    'message' => $message,
                    'name' => $name
                ];
            }
        }
    }

    /**
     * @return array
     */
    public function getLog()
    {
        return $this->log;
    }
}
