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
    public function loadRules($path)
    {
        // use autoloader here

        //$targets = \HexletPsrLinter\getTargetFiles($path);
        //foreach ($targets as $target) {
            /*include($target);
            $className = basename($target, ".php");
            if (class_exists($className)) {
                $implements = class_implements($className);
            }
                //call_user_func(array($classname, 'getInstance'));
        }*/
    }

    /**
     * @return mixed
     */
    public function getRules()
    {
        return $this->rules;
    }
}
