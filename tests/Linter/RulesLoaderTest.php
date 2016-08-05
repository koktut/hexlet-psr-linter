<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Linter\Loader\RulesLoader;
use HexletPsrLinter\Linter\RulesLoadVisitor;
use HexletPsrLinter\Logger\Logger;

/**
 * Class RulesLoadVisitoTest
 */
class RulesLoaderTest extends \PHPUnit_Framework_TestCase
{
    private $rulesLoader;

    public function setUp()
    {
        $this->rulesLoader = new RulesLoader();
    }

    public function testLoadRules()
    {
        $this->rulesLoader->loadRules(__DIR__ . '/../fixtures/rules');
        $this->assertEquals(['TestRules\AnotherTestRules','TestRules\TestRules'], $this->rulesLoader->getRules());
        $this->assertEquals(3, $this->rulesLoader->getLog()->getSize());
    }
}
