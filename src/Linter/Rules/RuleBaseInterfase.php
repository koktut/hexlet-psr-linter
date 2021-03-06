<?php

namespace HexletPsrLinter\Linter\Rules;

/**
 * Interface RulesBaseInterfase
 * @package HexletPsrLinter\Linter
 */
interface RuleBaseInterfase
{
    /**
     * @return mixed
     */
    public static function getDescription();

    /**
     * @param $node
     * @return mixed
     */
    public function validate($node);

    /**
     * @param $node
     * @return mixed
     */
    public function fix($node);
}
