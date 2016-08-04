<?php

namespace HexletPsrLinter\Linter;

use PhpParser\Node;
use PhpParser\Node\Stmt;

/**
 * Class TestRules
 * @package HexletPsrLinter\Linter
 */
class TestRules implements RulesBaseInterfase
{
    /**
     * @param $node
     * @return mixed
     */
    public function validate($node)
    {
        // TODO: Implement validate() method.
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
