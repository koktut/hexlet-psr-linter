<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Logger\Logger;
use HexletPsrLinter\Logger\LogRecord;
use PhpParser\Node\Stmt;

class LoggerTest extends \PHPUnit_Framework_TestCase
{
    private $logger;

    public function setUp()
    {
        $this->logger = new Logger();
    }

    public function testGetRecord()
    {
        $record = new LogRecord(1, 1, Logger::LOGLEVEL_ERROR, "message", "name");
        $this->logger->addRecord($record);
        $record = $this->logger->getRecord(0);
        $this->assertEquals("message", $record->getMessage());
    }

    public function testGetSize()
    {
        $record = new LogRecord(1, 1, Logger::LOGLEVEL_ERROR, "message", "name");
        $this->logger->addRecord($record);
        $this->logger->addRecord($record);
        $this->logger->addRecord($record);
        $this->assertEquals(3, $this->logger->getSize());
    }

    public function testClear()
    {
        $record = new LogRecord(1, 1, Logger::LOGLEVEL_ERROR, "message", "name");
        $this->logger->addRecord($record);
        $this->logger->addRecord($record);
        $this->logger->addRecord($record);
        $this->logger->clear();
        $this->assertEquals(0, $this->logger->getSize());
    }

    public function testGetStatistics()
    {
        $errRecord = new LogRecord(1, 1, Logger::LOGLEVEL_ERROR, "message", "name");
        $warnRecord = new LogRecord(1, 1, Logger::LOGLEVEL_WARNING, "message", "name");

        $this->logger->addRecord($errRecord);
        $this->logger->addRecord($errRecord);
        $this->logger->addRecord($errRecord);
        $this->logger->addRecord($warnRecord);
        $this->logger->addRecord($warnRecord);

        $this->assertEquals(['err' => 3, 'warn' => 2], $this->logger->getStatistics());
    }

    /**
    * @expectedException OutOfRangeException
    */
    public function testIndexOfRangeException()
    {
        $this->logger->getRecord(10);
    }

    public function testGetLevelAsText()
    {
        $this->assertEquals('error', $this->logger->getLevelAsText(Logger::LOGLEVEL_ERROR));
        $this->assertEquals('warning', $this->logger->getLevelAsText(Logger::LOGLEVEL_WARNING));
        $this->assertEquals('', $this->logger->getLevelAsText(-1));
    }

    public function testToArrayEmpty()
    {
        $this->assertEquals([], $this->logger->toArray());
    }

    public function testToArray()
    {
        $this->logger->addRecord(new LogRecord(0, 1, 1, '', ''));
        $this->logger->addRecord(new LogRecord(0, 1, 1, '', ''));
        $this->logger->addRecord(new LogRecord(0, 1, 1, '', ''));
        $this->assertEquals(3, count($this->logger->toArray()));
    }
}
