<?php

namespace TestRules;

use HexletPsrLinter\Linter\RulesBaseInterfase;

/**
 * Class AntotherTetsRules
 * @package HexletPsrLinter\Linter
 */
class AnotherTestRules implements RulesBaseInterfase
{

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
}