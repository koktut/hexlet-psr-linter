<?php

namespace HexletPsrLinter\Linter;

/**
 * Class RulesLoader
 * @package HexletPsrLinter\Linter
 */
class RulesLoader
{
    private $rules;

    /**
     * RulesLoader constructor.
     */
    public function __construct()
    {
        $this->rules = [];
    }

    /**
     * @param $path
     */
    public function loadRules($namespace, $path)
    {
        $targets = \HexletPsrLinter\getTargetFiles($path);
        foreach ($targets as $target) {
            $className = $namespace . '\\'. basename($target, ".php");
            include($target);
            if (class_exists($className)) {
                $implements = class_implements($className);
                if (in_array(RulesBaseInterfase::class, $implements)) {
                    $this->rules []= $className;
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function getRules()
    {
        return $this->rules;
    }
}
