<?php

namespace HexletPsrLinter;

use PhpParser\Node;
use HexletPsrLinter\Linter\LogItem;

class LogItemTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $logItem = new LogItem(1, LogItem::LOGLEVEL_ERROR, "message", "name");
        $this->assertEquals(1, $logItem->getLine());
        $this->assertEquals(LogItem::LOGLEVEL_ERROR, $logItem->getLevel());
        $this->assertEquals("message", $logItem->getMessage());
        $this->assertEquals("name", $logItem->getName());
    }

    public function testSetLine()
    {
        $logItem = new LogItem(0, LogItem::LOGLEVEL_ERROR, "message", "name");
        $logItem->setLine(1);
        $this->assertEquals(1, $logItem->getLine());
    }

    public function testSetLevel()
    {
        $logItem = new LogItem(0, 1, "message", "name");
        $logItem->setLevel(3);
        $this->assertEquals(3, $logItem->getLevel());
    }

    public function testSetMessage()
    {
        $logItem = new LogItem(0, LogItem::LOGLEVEL_ERROR, "", "name");
        $logItem->setMessage("message");
        $this->assertEquals("message", $logItem->getMessage());
    }

    public function testSetName()
    {
        $logItem = new LogItem(0, LogItem::LOGLEVEL_ERROR, "message", "");
        $logItem->setName("name");
        $this->assertEquals("name", $logItem->getName());
    }
}
