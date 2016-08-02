<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Linter\PsrLinter;

/**
 * Class PsrLinterTest
 * @package PsrLinter
 */
class PsrLinterTest extends \PHPUnit_Framework_TestCase
{
    private $linter;

    public function setUp()
    {
        $this->linter = new PsrLinter();
    }

    public function testLintEmpty()
    {
        $logger = $this->linter->lint("");
        $this->assertTrue($logger->getSize() == 0);
    }
    
    public function name()
    {
        $node = new \PhpParser\Node\Stmt\Function_("test");
    }
}
