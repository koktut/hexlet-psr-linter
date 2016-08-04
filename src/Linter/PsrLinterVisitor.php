<?php

namespace HexletPsrLinter\Linter;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;
use PhpParser\Node\Stmt;
use PhpParser\NodeTraverser;
use HexletPsrLinter\Logger\Logger;
use HexletPsrLinter\Logger\LogRecord;
use PhpParser\PrettyPrinter;

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
    private $autoFix;
    private $prettyCode;

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
     * @param bool $autoFix - In case of true - pretty code will be generated (avaiable by getPrettyCode method)
     * @return Logger
     */
    public function lint($code, $autoFix = false)
    {
        $this->autoFix = $autoFix;
        $this->prettyCode = '';

        $this->logger = new Logger();

        $stmts = $this->parser->parse($code);
        $traverser = new NodeTraverser;
        $rulesVisitor = new RulesVsistor($this->rules, $this->autoFix);
        $traverser->addVisitor($rulesVisitor);
        $traverser->traverse($stmts);
        $messages = $rulesVisitor->getMessages();
        foreach ($messages as $message) {
            $this->logger->addRecord(
                new LogRecord(
                    $message['line'],
                    $message['column'],
                    $message['level'],
                    $message['message'],
                    $message['name']
                )
            );
        }

        if ($autoFix) {
            $prettyPrinter = new PrettyPrinter\Standard();
            $this->prettyCode = $prettyPrinter->prettyPrint($stmts);
        }

        $sideEffectVisitor = new SideEffectsDeclarationsVisitor();
        $traverser->addVisitor($sideEffectVisitor);
        $traverser->traverse($stmts);
        if ($sideEffectVisitor->isMixed()) {
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
     * @return mixed
     */
    public function getPrettyCode()
    {
        return $this->prettyCode;
    }
}
