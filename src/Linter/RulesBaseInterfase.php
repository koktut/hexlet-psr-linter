<?php

namespace HexletPsrLinter\Linter;

/**
 * Interface RulesBaseInterfase
 * @package HexletPsrLinter\Linter
 */
interface RulesBaseInterfase
{
    /**
     * @param $node
     * @return mixed
     */
    public function validate($node);
}
