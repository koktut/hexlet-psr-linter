<?php

namespace PsrLinter;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;
use PhpParser\Node\Stmt;
use PhpParser\NodeTraverser;

/**
 * Class PsrLinter
 * @package PhpPsrLinter
 */
class PsrLinter extends NodeVisitorAbstract
{
    private $parser;
    private $rules;
    private $log;

    /**
     * PsrLinter constructor.
     */
    public function __construct()
    {
        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $this->rules = new Rules();
        $this->log = [];
    }

    /**
     * @param $code
     * @return mixed
     */
    public function lint($code)
    {
        $stmts = $this->parser->parse($code);
        $traverser = new NodeTraverser;
        $traverser->addVisitor($this);
        $traverser->traverse($stmts);
        
        return $this->log;
    }

    public function leaveNode(Node $node)
    {
        if ($node instanceof Stmt\Function_) {
            if (!$this->rules->validateFunctionName($node->name)) {
                $logItem = new LogItem($node, "Function name is not in camel caps format", LogItem::LOGLEVEL_ERROR);
                $this->log []= $logItem;
            };
        }
        
        if ($node instanceof Stmt\ClassMethod) {
            if (!$this->rules->validateFunctionName($node->name)) {
                $logItem = new LogItem($node, "Method name is not in camel caps format", LogItem::LOGLEVEL_ERROR);
                $this->log []= $logItem;
            };
        }

        if ($node instanceof Node\Expr\Variable) {
            $this->rules->validateVariableName($node->name);
        }
    }
}
