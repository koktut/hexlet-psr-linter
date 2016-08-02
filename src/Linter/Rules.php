<?php

namespace HexletPsrLinter\Linter;

/**
 * Interface Rules
 * @package HexletPsrLinter\Linter
 */
interface Rules
{
    /**
     * @param $node
     * @return mixed
     */
    public function validate($node);
}
