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
class PsrLinterVisitor extends NodeVisitorAbstract
{
    private $parser;
    private $rules;
    private $logger;

    /**
     * PsrLinter constructor.
     * @param $rules
     */
    public function __construct($rules)
    {
        $this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $this->rules = $rules;
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
        foreach ($this->rules as $rule) {
            $vaildator = new $rule;

            $result = $vaildator->validate($node);

            if ($result !== true) {
                list($level, $message) = $result;
                $this->logger->addRecord(
                    new LogRecord(
                        $node->getAttribute('startLine'),
                        0,
                        $level,
                        $message,
                        $node->name
                    )
                );
            }
        }
    }
}
