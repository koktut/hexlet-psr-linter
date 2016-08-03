<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Linter\DefaultRules;
use HexletPsrLinter\Linter\PsrLinterVisitor;

/**
 * Class PsrLinterTest
 * @package PsrLinter
 */
class PsrLinterTest extends \PHPUnit_Framework_TestCase
{
    public function testLintEmpty()
    {
        $logger = (new PsrLinterVisitor([DefaultRules::class]))->lint("");
        $this->assertTrue($logger->getSize() == 0);
    }

    public function testLintBad()
    {
        $logger = (new PsrLinterVisitor([DefaultRules::class]))->lint("<?php function f_t(){}");
        $this->assertTrue($logger->getSize() != 0);
    }
}
