<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Logger\LogRecord;
use HexletPsrLinter\Logger\Logger;
use PhpParser\Node;

class LogItemTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $logRecord = new LogRecord(1, 2, Logger::LOGLEVEL_ERROR, "message", "name");
        $this->assertEquals(1, $logRecord->getLine());
        $this->assertEquals(2, $logRecord->getColumn());
        $this->assertEquals(Logger::LOGLEVEL_ERROR, $logRecord->getLevel());
        $this->assertEquals("message", $logRecord->getMessage());
        $this->assertEquals("name", $logRecord->getName());
    }

    public function testSetLine()
    {
        $logRecord = new LogRecord(0, 0, Logger::LOGLEVEL_ERROR, "message", "name");
        $logRecord->setLine(1);
        $this->assertEquals(1, $logRecord->getLine());
    }

    public function testColumnLine()
    {
        $logRecord = new LogRecord(0, 0, Logger::LOGLEVEL_ERROR, "message", "name");
        $logRecord->setColumn(1);
        $this->assertEquals(1, $logRecord->getColumn());
    }

    public function testSetLevel()
    {
        $logRecord = new LogRecord(0, 0, 0, "message", "name");
        $logRecord->setLevel(3);
        $this->assertEquals(3, $logRecord->getLevel());
    }

    public function testSetMessage()
    {
        $logRecord = new LogRecord(0, 1, Logger::LOGLEVEL_ERROR, "", "name");
        $logRecord->setMessage("message");
        $this->assertEquals("message", $logRecord->getMessage());
    }

    public function testSetName()
    {
        $logRecord = new LogRecord(0, 1, Logger::LOGLEVEL_ERROR, "message", "");
        $logRecord->setName("name");
        $this->assertEquals("name", $logRecord->getName());
    }
}
