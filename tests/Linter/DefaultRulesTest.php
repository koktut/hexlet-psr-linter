<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Linter\Rules\DefaultRules;
use PhpParser\Node\Stmt;
use PhpParser\Node;

/**
 * Class RulesTest
 * @package PsrLinter
 */
class DefaultRulesTest extends \PHPUnit_Framework_TestCase
{
    private $rules;

    public function setUp()
    {
        $this->rules = new DefaultRules();
    }

    public function testNoRules()
    {
        $this->assertTrue($this->rules->validate(null));
    }

    public function testValidateFunctionNamesWithValidNames()
    {
        $this->assertTrue($this->rules->validate(new Stmt\Function_('functionName')));
        $this->assertTrue($this->rules->validate(new Stmt\Function_('functionname')));
        $this->assertTrue($this->rules->validate(new Stmt\Function_('func')));
    }

    public function testValidateFunctionNamesWithInvalidNames()
    {
        $this->assertNotTrue($this->rules->validate(new Stmt\Function_('FunctionName')));
        $this->assertNotTrue($this->rules->validate(new Stmt\Function_('function-name')));
    }

    public function testValidateMethodNamesWithValidNames()
    {
        $this->assertTrue($this->rules->validate(new Stmt\ClassMethod('methodName')));
        $this->assertTrue($this->rules->validate(new Stmt\ClassMethod('methodname')));
        $this->assertTrue($this->rules->validate(new Stmt\ClassMethod('method')));
        $this->assertTrue($this->rules->validate(new Stmt\ClassMethod('__construct')));
    }

    public function testValidateMethodNamesWithInvalidNames()
    {
        $this->assertNotTrue($this->rules->validate(new Stmt\ClassMethod('MethodName')));
        $this->assertNotTrue($this->rules->validate(new Stmt\ClassMethod('method-name')));
    }

    public function testValidateVariableNamesWithValidNames()
    {
        $this->assertTrue($this->rules->validate(new Node\Expr\Variable('varName')));
        $this->assertTrue($this->rules->validate(new Node\Expr\Variable('varame')));
        $this->assertTrue($this->rules->validate(new Node\Expr\Variable('VarName')));
        $this->assertTrue($this->rules->validate(new Node\Expr\Variable('var')));
    }

    public function testValidateVariableNamesWithInvalidNames()
    {
        $this->assertNotTrue($this->rules->validate(new Node\Expr\Variable('var_name')));
        $this->assertNotTrue($this->rules->validate(new Node\Expr\Variable('var-name')));
    }
    
    public function testFixVariableName()
    {
        $this->assertEquals('MyVarName', $this->rules->fixVariableName('_my_var_name'));
        $this->assertEquals('MyVarName', $this->rules->fixVariableName('_my_var_name_'));
        $this->assertEquals('MyVarName', $this->rules->fixVariableName('my_var_name_'));
        $this->assertEquals('MyVarName', $this->rules->fixVariableName('my___var_name_'));
    }
}
