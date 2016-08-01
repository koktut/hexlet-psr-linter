<?php

namespace PsrLinter;

use PhpParser\Node;

class LogItemTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $logItem = new LogItem("node", "message", LogItem::LOGLEVEL_ERROR);
        $this->assertEquals("node", $logItem->getNode());
        $this->assertEquals("message", $logItem->getMessage());
        $this->assertEquals(LogItem::LOGLEVEL_ERROR, $logItem->getLevel());
    }

    public function testSetNode()
    {
        $logItem = new LogItem("", "", 1);
        $logItem->setNode("node");
        $this->assertEquals("node", $logItem->getNode());
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
