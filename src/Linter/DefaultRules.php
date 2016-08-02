<?php

namespace HexletPsrLinter\Linter;

use PhpParser\Node;
use PhpParser\Node\Stmt;

/**
 * Class TestRules
 * @package HexletPsrLinter\Linter
 */
class DefaultRules
{
    public function validate($node)
    {
        if ($node instanceof Stmt\Function_) {
            if (!$this->rules->validateFunctionName($node->name)) {
                $this->logger->addRecord($this->makeErrorRecord($node, "Function name is not in camel caps format"));
            };
        }

        if ($node instanceof Stmt\ClassMethod) {
            if (!$this->rules->validateFunctionName($node->name)) {
                $this->logger->addRecord($this->makeErrorRecord($node, "Method name is not in camel caps format"));
            };
        }

        if ($node instanceof Node\Expr\Variable) {
            $this->rules->validateVariableName($node->name);
        }
    }
}
