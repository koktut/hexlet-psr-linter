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
        $targets = \HexletPsrLinter\getTargetFiles($path);
    }

    /**
     * @return mixed
     */
    public function getRules()
    {
        return $this->rules;
    }
}
