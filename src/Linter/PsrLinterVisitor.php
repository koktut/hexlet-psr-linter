<?php

namespace HexletPsrLinter\Linter;

use PhpParser\Node;
use PhpParser\NodeDumper;
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
    const VISITOR_MODE_LINTER = 1;
    const VISITOR_MODE_SIDE_EFFECTS = 2;

    private $parser;
    private $rules;
    private $logger;
    private $visitorMode;

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

        $this->visitorMode = self::VISITOR_MODE_LINTER;
        $stmts = $this->parser->parse($code);
        $traverser = new NodeTraverser;
        $traverser->addVisitor($this);
        $traverser->traverse($stmts);

        $this->visitorMode = self::VISITOR_MODE_SIDE_EFFECTS;
        $traverser->traverse($stmts);

        return $this->logger;
    }

    /**
     * Callback function for visitor
     *
     * @param Node $node
     * @return void
     */
    public function enterNode(Node $node)
    {
        switch ($this->visitorMode) {
            case self::VISITOR_MODE_LINTER:
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
                break;
            case self::VISITOR_MODE_SIDE_EFFECTS:
                if ($this->visitorMode == self::VISITOR_MODE_SIDE_EFFECTS && !($node instanceof Stmt\Namespace_)) {
                    return NodeTraverser::DONT_TRAVERSE_CHILDREN;
                }
                break;
        }
    }

    /**
     * @param $node
     */
    private function isDeclaration($node)
    {
    }

    /**
     * @param $node
     * @return mixed
     */
    private function isSideEffect($node)
    {
        $sideEffectNodeTypes = [
            Node\Expr\Include_::class,
            Node\Expr\FuncCall::class,
            Node\Stmt\Echo_::class
        ];

        return in_array($node, $sideEffectNodeTypes);
    }
}
