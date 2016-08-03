<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Logger\Logger;
use HexletPsrLinter\Logger\LogRecord;
use HexletPsrLinter\ReportBuilder\ReportYml;

/**
 * Class ReportYmlTest
 * @package HexletPsrLinter
 */
class ReportYmlTest extends \PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $logger = new Logger();
        $report = new ReportYml();
        $this->assertEquals('{  }', $report->build($logger));
    }

    public function testBuild()
    {
        $logger = new Logger();
        $logger->addRecord(
            new LogRecord(1, 0, Logger::LOGLEVEL_ERROR, 'message', 'text')
        );
        $report = new ReportYml();
        $this->assertNotEquals('{  }', $report->build($logger));
    }
}
