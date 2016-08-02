<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Linter\Rules;

/**
 * Class RulesTest
 * @package PsrLinter
 */
class RulesTest extends \PHPUnit_Framework_TestCase
{
    private $rules;
    public function setUp()
    {
        $this->rules = new Rules();
    }

    public function testValidateFunctionNamesWithValidNames()
    {
        $this->assertTrue($this->rules->validateFunctionName('__construct'));
        $this->assertTrue($this->rules->validateFunctionName('functionName'));
        $this->assertTrue($this->rules->validateFunctionName('functionname'));
        $this->assertTrue($this->rules->validateFunctionName('func'));
    }

    public function testValidateFunctionNamesWithInvalidNames()
    {
        $this->assertFalse($this->rules->validateFunctionName('!functionName'));
        $this->assertFalse($this->rules->validateFunctionName('1functionName'));
        $this->assertFalse($this->rules->validateFunctionName('FunctionName'));
    }

    public function testValidateVariableNamesWithValidNames()
    {
        $this->assertTrue($this->rules->validateVariableName('functionName'));
        $this->assertTrue($this->rules->validateVariableName('functionname'));
        $this->assertTrue($this->rules->validateVariableName('func'));
    }

    public function testValidateVariableNamesWithInvalidNames()
    {
        $this->assertFalse($this->rules->validateVariableName('!functionName'));
        $this->assertFalse($this->rules->validateVariableName('1functionName'));
        $this->assertFalse($this->rules->validateVariableName('FunctionName'));
    }
}
