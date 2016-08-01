<?php

namespace PsrLinter;

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
        return \PHP_CodeSniffer::isCamelCaps($name);
    }

    /**
     * @param $name
     * @return bool
     */
    public function validateVariableName($name)
    {
        //return \PHP_CodeSniffer::isCamelCaps($name);
    }
}
