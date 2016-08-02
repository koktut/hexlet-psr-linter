<?php

namespace PsrLinter;

use Linter\PsrLinter;

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
        $this->assertTrue(empty($this->linter->lint("")));
    }
}
