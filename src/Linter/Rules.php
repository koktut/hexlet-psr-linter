<?php

namespace HexletPsrLinter\Linter;

/**
 * Class Rules
 * @package PsrLinter
 */
class Rules
{
    /**
     * @param $name
     * @return bool
     */
    public function validateFunctionName($name)
    {
        if ($name == '__construct') {
            return true;
        }
        return \PHP_CodeSniffer::isCamelCaps($name, false, true, true);
    }

    /**
     * @param $name
     * @return bool
     */
    public function validateVariableName($name)
    {
        return \PHP_CodeSniffer::isCamelCaps($name);
    }
}
