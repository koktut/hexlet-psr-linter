<?php

namespace TestRules;

use HexletPsrLinter\Linter\Rules\RuleBaseInterfase;

/**
 * Class AntotherTetsRules
 * @package HexletPsrLinter\Linter
 */
class AnotherTestRules implements RuleBaseInterfase
{
    /**
     * @return string
     */
    public static function getDescription()
    {
        // TODO: Implement getDescription() method.
        return "Another awsome rules!";
    }

    /**
     * @param $node
     * @return mixed
     */
    public function validate($node)
    {
        // TODO: Implement validate() method.
        return "AnotherTestRules";
    }

    /**
     * @param $node
     * @return mixed
     */
    public function fix($node)
    {
        // TODO: Implement fix() method.
    }

    /**
     * @return mixed
     */
}
