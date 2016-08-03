<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Logger\Logger;
use HexletPsrLinter\Logger\LogRecord;
use HexletPsrLinter\ReportBuilder\ReportTxt;

/**
 * Class ReportTxtTest
 * @package Test
 */
class ReportTxtTest extends \PHPUnit_Framework_TestCase
{

    public function testEmpty()
    {
        $logger = new Logger();
        $report = new ReportTxt();
        $this->assertEquals('', $report->build($logger));
    }

    public function testBuild()
    {
        $logger = new Logger();
        $logger->addRecord(
            new LogRecord(1, 0, Logger::LOGLEVEL_ERROR, 'message', 'text')
        );
        $report = new ReportTxt();
        $this->assertNotEquals('', $report->build($logger));
    }
}
