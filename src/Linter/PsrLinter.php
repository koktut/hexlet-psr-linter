<?php

namespace HexletPsrLinter\Linter;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;
use PhpParser\Node\Stmt;
use PhpParser\NodeTraverser;
use HexletPsrLinter\Logger\Logger;
use HexletPsrLinter\Logger\LogRecord;

/**
 * Class PsrLinter
 * @package PhpPsrLinter
 */
class PsrLinter extends NodeVisitorAbstract
{
    private $parser;
    private $rules;
    private $logger;
    
    /**
     * PsrLinter constructor.
     */
    public function __construct()
    {
        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $this->rules = new Rules();
    }

    /**
     * @param $code
     * @return Logger
     */
    public function lint($code)
    {
        $this->logger = new Logger();
        $stmts = $this->parser->parse($code);
        $traverser = new NodeTraverser;
        $traverser->addVisitor($this);
        $traverser->traverse($stmts);
        
        return $this->logger;
    }

    /**
     * Callback function for visitor
     *
     * @param Node $node
     * @return void
     */
    public function leaveNode(Node $node)
    {
        if ($node instanceof Stmt\Function_) {
            if (!$this->rules->validateFunctionName($node->name)) {
                $this->logger->addRecord($this->makeErrorRecord($node, "Function name is not in camel caps format"));
            };
        }
        
        if ($node instanceof Stmt\ClassMethod) {
            if (!$this->rules->validateFunctionName($node->name)) {
                $this->logger->addRecord($this->makeErrorRecord($node, "Method name is not in camel caps format"));
            };
        }

        if ($node instanceof Node\Expr\Variable) {
            $this->rules->validateVariableName($node->name);
        }
    }

    /**
     * @param $node
     * @param $message
     * @return LogRecord
     */
    private function makeErrorRecord($node, $message)
    {
        return $logRecord = new LogRecord(
            $node->getAttribute("startLine"),
            0,
            Logger::LOGLEVEL_ERROR,
            $message,
            $node->name
        );
    }
}
