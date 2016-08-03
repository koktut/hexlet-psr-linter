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
    private $sideEffects;
    private $declarations;

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

        $this->sideEffects = false;
        $this->declarations = false;
        $this->visitorMode = self::VISITOR_MODE_SIDE_EFFECTS;
        $traverser->traverse($stmts);
        if ($this->sideEffects && $this->declarations) {
            $this->logger->addRecord(
                new LogRecord(
                    '',
                    '',
                    Logger::LOGLEVEL_ERROR,
                    'A file SHOULD declare new symbols (classes, functions, constants, etc.) and cause no other side' .
                    'effects, or it SHOULD execute logic with side effects, but SHOULD NOT do both.',
                    ''
                )
            );
        }

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
                    $this->sideEffects |= $this->isSideEffect($node);
                    $this->declarations |= $this->isDeclaration($node);
                    return NodeTraverser::DONT_TRAVERSE_CHILDREN;
                }
                break;
        }
    }

    /**
     * @param $node
     * @return bool
     */
    private function isDeclaration($node)
    {
        $declarationNodeTypes = [
            Node\Stmt::class,
        ];

        if ($node instanceof Node\Stmt\Echo_) {
            return false;
        }
        foreach ($declarationNodeTypes as $type) {
            if ($node instanceof $type) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $node
     * @return mixed
     */
    private function isSideEffect($node)
    {
        $sideEffectNodeTypes = [
            Node\Expr::class,
            Node\Stmt\Echo_::class
        ];

        foreach ($sideEffectNodeTypes as $type) {
            if ($node instanceof $type) {
                return true;
            }
        }
        return false;
    }
}
