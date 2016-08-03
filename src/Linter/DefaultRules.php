<?php

namespace HexletPsrLinter\Linter;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use HexletPsrLinter\Logger\Logger;

/**
 * Class TestRules
 * @package HexletPsrLinter\Linter
 */
class DefaultRules implements Rules
{
    /**
     * @param $node
     * @return bool|string
     */
    public function validate($node)
    {
        if ($node instanceof Stmt\Function_) {
            if (!\PHP_CodeSniffer::isCamelCaps($node->name, false, true, true)) {
                return [Logger::LOGLEVEL_ERROR, "Function name is not in camel caps format"];
            }
            return true;
        }

        if ($node instanceof Stmt\ClassMethod) {
            if ($this->isMagicMethod($node->name)) {
                return true;
            }

            if (!\PHP_CodeSniffer::isCamelCaps($node->name, false, true, true)) {
                return [Logger::LOGLEVEL_ERROR, "Method name is not in camel caps format"];
            }
            return true;
        }

        if ($node instanceof Node\Expr\Variable) {
            if (!\PHP_CodeSniffer::isCamelCaps($node->name, false, true, true)
                && !\PHP_CodeSniffer::isCamelCaps($node->name, true, true, true)) {
                return [Logger::LOGLEVEL_WARNING, "Variable name is not in camel caps format"];
            }
            return true;
        }

        return true;
    }

    /**
     * @param $methodName
     */
    private function isMagicMethod($methodName)
    {
        $magicMethods = [
            '__construct', '__destruct', '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep',
            '__wakeup', '__toString', '__invoke', '__set_state', '__clone', '__debugInfo'
        ];

        return in_array($methodName, $magicMethods);
    }

}
