<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Linter\DefaultRules;
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
        $this->assertTrue($this->rules->validate(new Stmt\Function_("functionName")));
        $this->assertTrue($this->rules->validate(new Stmt\Function_("functionname")));
        $this->assertTrue($this->rules->validate(new Stmt\Function_("func")));
    }

    public function testValidateFunctionNamesWithInvalidNames()
    {
        $this->assertNotTrue($this->rules->validate(new Stmt\Function_("FunctionName")));
        $this->assertNotTrue($this->rules->validate(new Stmt\Function_("function-name")));
        $this->assertNotTrue($this->rules->validate(new Stmt\Function_("1functionName")));
        $this->assertNotTrue($this->rules->validate(new Stmt\Function_("!functionName")));
    }

    public function testValidateMathodNamesWithValidNames()
    {
        $this->assertTrue($this->rules->validate(new Stmt\ClassMethod("methodName")));
        $this->assertTrue($this->rules->validate(new Stmt\ClassMethod("methodname")));
        $this->assertTrue($this->rules->validate(new Stmt\ClassMethod("method")));
    }

    public function testValidateMethodNamesWithInvalidNames()
    {
        $this->assertNotTrue($this->rules->validate(new Stmt\ClassMethod("MethodName")));
        $this->assertNotTrue($this->rules->validate(new Stmt\ClassMethod("method-name")));
        $this->assertNotTrue($this->rules->validate(new Stmt\ClassMethod("1methodName")));
        $this->assertNotTrue($this->rules->validate(new Stmt\ClassMethod("!methodName")));
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
        $this->assertNotTrue($this->rules->validate(new Node\Expr\Variable("var_name")));
        $this->assertNotTrue($this->rules->validate(new Node\Expr\Variable("var-name")));
        $this->assertNotTrue($this->rules->validate(new Node\Expr\Variable("1var")));
        $this->assertNotTrue($this->rules->validate(new Node\Expr\Variable("!var")));
    }
}
