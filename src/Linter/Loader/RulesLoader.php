<?php

namespace HexletPsrLinter\Linter\Loader;

use function HexletPsrLinter\getTargetFiles;
use HexletPsrLinter\Linter\Rules\RuleBaseInterfase;
use HexletPsrLinter\Logger\Logger;
use HexletPsrLinter\Logger\LogRecord;
use PhpParser\NodeTraverser;
use PhpParser\Node;
use PhpParser\ParserFactory;

/**
 * Class RulesLoader
 * @package HexletPsrLinter\Linter\Loader
 */
class RulesLoader
{
    private $rules;
    private $log;

    /**
     * RulesLoader constructor.
     */
    public function __construct()
    {
        $this->rules = [];
        $this->log = new Logger();
    }

    /**
     * @param $rulesPath
     * @return array
     */
    public function loadRules($rulesPath)
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);

        $targetFiles = getTargetFiles($rulesPath);
        foreach ($targetFiles as $file) {
            $code = file_get_contents($file);
            $stmts = $parser->parse($code);
            $traverser = new NodeTraverser();
            $visitor = new RulesLoadVisitor();
            $traverser->addVisitor($visitor);
            $traverser->traverse($stmts);

            $namespace = $visitor->getNamespace();
            $className = $visitor->getClassName();
            if (!is_null($namespace) && !is_null($className)) {
                include($file);
                $fullClassName = $namespace . '\\' . $className;
                if (class_exists($fullClassName)) {
                    $implements = class_implements($fullClassName);
                    if (in_array(RuleBaseInterfase::class, $implements)) {
                        $this->rules [] = $fullClassName;
                        $this->addRecord(
                            Logger::LOGLEVEL_OK,
                            "Loaded rules: {$fullClassName}  - " . $fullClassName::getDescription(),
                            $file
                        );
                    } else {
                        $this->addRecord(
                            Logger::LOGLEVEL_ERROR,
                            "Class $fullClassName must implements RulesBaseInterface",
                            $file
                        );
                    }
                } else {
                    $this->addRecord(
                        Logger::LOGLEVEL_ERROR,
                        "Class $fullClassName doesn't exists in $file",
                        $file
                    );
                }
            } else {
                $this->addRecord(
                    Logger::LOGLEVEL_ERROR,
                    'File doesn\'t contains correct class defenition',
                    $file
                );
            }
        }

        return $this->rules;
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @return Logger
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * @param $level
     * @param $message
     * @param $name
     * @return bool
     */
    private function addRecord($level, $message, $name)
    {
        $this->log->addRecord(
            new LogRecord(
                '',
                '',
                $level,
                $message,
                $name
            )
        );
    }
}
