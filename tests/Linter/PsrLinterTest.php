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

    public function testLintFunctionNameError()
    {
        $logger = (new PsrLinterVisitor([DefaultRules::class]))->lint("<?php function f_t(){}");
        $this->assertTrue($logger->getSize() == 1);
        $this->assertEquals('f_t', $logger->getRecord(0)->getName());
    }

    public function testLintSideEffectAndDeclarationsNegativeSE()
    {
        $code = file_get_contents(__DIR__ . '/../fixtures/sideeffects.php');
        $logger = (new PsrLinterVisitor([DefaultRules::class]))->lint($code);
        $this->assertTrue($logger->getSize() == 0);
    }

    public function testLintSideEffectAndDeclarationsNegativeDecl()
    {
        $code = file_get_contents(__DIR__ . '/../fixtures/declarations.php');
        $logger = (new PsrLinterVisitor([DefaultRules::class]))->lint($code);
        $this->assertTrue($logger->getSize() == 0);
    }

    public function testLintSideEffectAndDeclarationsPositive()
    {
        $code = file_get_contents(__DIR__ . '/../fixtures/se_decl_mixed.php');
        $logger = (new PsrLinterVisitor([DefaultRules::class]))->lint($code);
        $this->assertTrue($logger->getSize() != 0);
    }
}
