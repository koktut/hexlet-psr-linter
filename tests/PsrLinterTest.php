<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Linter\DefaultRules;
use HexletPsrLinter\Linter\PsrLinterVisitor;
use HexletPsrLinter\Linter\Rules;

/**
 * Class PsrLinterTest
 * @package PsrLinter
 */
class PsrLinterTest extends \PHPUnit_Framework_TestCase
{
    public function testLintEmpty()
    {
        $logger = (new PsrLinterVisitor(new DefaultRules()))->lint("");
        $this->assertTrue($logger->getSize() == 0);
    }

    public function testVildate()
    {
        $rules = $this->getMockBuilder(DefaultRules::class)
            ->setMethods(['validate'])
            ->getMock();
        $rules->expects($this->once())
            ->method('validate')
            ->with();

        $linter = new PsrLinterVisitor($rules);
        $linter->lint("<?php function name() {}");
    }
}
