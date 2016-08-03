<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Logger\Logger;
use HexletPsrLinter\Logger\LogRecord;
use HexletPsrLinter\ReportBuilder\ReportJson;

/**
 * Class ReportJsonTest
 * @package HexletPsrLinter
 */
class ReportJsonTest extends \PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $logger = new Logger();
        $report = new ReportJson();
        $this->assertEquals('[]', $report->build($logger));
    }

    public function testBuild()
    {
        $logger = new Logger();
        $logger->addRecord(
            new LogRecord(1, 0, Logger::LOGLEVEL_ERROR, 'message', 'text')
        );
        $report = new ReportJson();
        $this->assertNotEquals('[]', $report->build($logger));
    }
}
