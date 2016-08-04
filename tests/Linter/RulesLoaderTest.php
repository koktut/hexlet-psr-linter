<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Linter\DefaultRules;
use HexletPsrLinter\Linter\RulesLoader;

/**
 * Class RulesLoaderTest
 * @package HexletPsrLinter
 */
class RulesLoaderTest extends \PHPUnit_Framework_TestCase
{
    private $rulesLoader;

    public function setUp()
    {
        $this->rulesLoader = new RulesLoader();
    }
    
    public function testGetRulesEmpty()
    {
        $this->assertEquals([], $this->rulesLoader->getRules());
    }

    public function testLoadRules()
    {
        //$this->rulesLoader->loadRules(__DIR__ . '/../fixtures/rules');
        //$this->assertEquals([DefaultRules::class], $this->rulesLoader->getRules());
    }
}
