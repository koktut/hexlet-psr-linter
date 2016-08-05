<?php

namespace TestRules;

use HexletPsrLinter\Linter\Rules\RuleBaseInterfase;

/**
 * Class TestRules
 * @package HexletPsrLinter\Linter
 */
class TestRules implements RuleBaseInterfase
{
    /**
     * @return mixed
     */
    public static function getDescription()
    {
        return "Awsome rules!";
    }

    /**
     * @param $node
     * @return mixed
     */
    public function validate($node)
    {
        // TODO: Implement validate() method.
        return "TestRules";
    }

    /**
     * @param $node
     * @return mixed
     */
    public function fix($node)
    {
        // TODO: Implement fix() method.
    }
}
