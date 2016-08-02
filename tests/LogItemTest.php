<?php

namespace HexletPsrLinter;

use PhpParser\Node;
use HexletPsrLinter\Linter\LogItem;

class LogItemTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $logItem = new LogItem(1, "message", LogItem::LOGLEVEL_ERROR);
        $this->assertEquals(1, $logItem->getLine());
        $this->assertEquals("message", $logItem->getMessage());
        $this->assertEquals(LogItem::LOGLEVEL_ERROR, $logItem->getLevel());
    }

    public function testSetLine()
    {
        $logItem = new LogItem(0, "", 1);
        $logItem->setLine(1);
        $this->assertEquals(1, $logItem->getLine());
    }

    public function testSetMessage()
    {
        $logItem = new LogItem("", "", 1);
        $logItem->setMessage("message");
        $this->assertEquals("message", $logItem->getMessage());
    }

    public function testSetLevel()
    {
        $logItem = new LogItem("", "", 1);
        $logItem->setLevel(3);
        $this->assertEquals(3, $logItem->getLevel());
    }
}
