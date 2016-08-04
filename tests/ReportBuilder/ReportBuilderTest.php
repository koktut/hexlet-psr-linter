<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Logger\Logger;
use HexletPsrLinter\ReportBuilder\ReportBulder;

/**
 * Class ReportBuilderTest
 * @package HexletPsrLinter
 */
class ReportBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildTxt()
    {
        $report = new ReportBulder('txt');
        $this->assertEquals('', $report->build());
    }

    public function testBuildJson()
    {
        $report = new ReportBulder('json');
        $this->assertEquals('[]', $report->build());
    }

    public function testBuildYml()
    {
        $report = new ReportBulder('yml');
        $this->assertEquals('{  }', $report->build());
    }
}
