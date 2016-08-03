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
    public function testBuild()
    {
        $logger = new Logger();
        $report = new ReportBulder();

        $this->assertEquals('', $report->buld('txt', $logger));
        $this->assertEquals('[]', $report->buld('json', $logger));
        $this->assertEquals('{  }', $report->buld('yml', $logger));
    }
}
