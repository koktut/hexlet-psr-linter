<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Linter\PsrLinter;
use HexletPsrLinter\Linter\Rules;

/**
 * Class PsrLinterTest
 * @package PsrLinter
 */
class PsrLinterTest extends \PHPUnit_Framework_TestCase
{
    public function testLintEmpty()
    {
        $logger = (new PsrLinter(new Rules()))->lint("");
        $this->assertTrue($logger->getSize() == 0);
    }

    public function testVildateFunctionName()
    {
        $rules = $this->getMockBuilder(Rules::class)
            ->setMethods(['validateFunctionName'])
            ->getMock();
        $rules->expects($this->once())
            ->method('validateFunctionName')
            ->with('name');

        $linter = new PsrLinter($rules);
        $linter->lint("<?php function name() {}");
    }

    public function testVildateMethodName()
    {
        $rules = $this->getMockBuilder(Rules::class)
            ->setMethods(['validateFunctionName'])
            ->getMock();
        $rules->expects($this->once())
            ->method('validateFunctionName')
            ->with('name');

        $linter = new PsrLinter($rules);
        $linter->lint("<?php class Test { public function name() {}}");
    }

    public function testValidateVariableName()
    {
        $rules = $this->getMockBuilder(Rules::class)
            ->setMethods(['validateVariableName'])
            ->getMock();
        $rules->expects($this->once())
            ->method('validateVariableName')
            ->with('var');

        $linter = new PsrLinter($rules);
        $linter->lint('<?php $var = 1;');
    }
}
