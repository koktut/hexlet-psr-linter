<?php

namespace HexletPsrLinter\Logger;

class Logger
{
    const LOGLEVEL_ERROR = 1;
    const LOGLEVEL_WARNING = 2;

    private $log;

    /**
     * Logger constructor.
     */
    public function __construct()
    {
        $this->log = [];
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return count($this->log);
    }

    /**
     * @param $logRecord
     */
    public function addRecord($logRecord)
    {
        $this->log []= $logRecord;
    }
    
    /**
     * @param $index
     * @return bool
     * @throws \OutOfRangeException If index is not in range
     */
    public function getRecord($index)
    {
        if ($index >= $this->getSize()) {
            throw new \OutOfRangeException("Index is out of range");
        }

        return $this->log[$index];
    }

    /**
     *
     */
    public function clear()
    {
        $this->log = [];
    }

    public function getStatistics()
    {
        $problems = $this->getSize();
        $err = count(
            array_filter($this->log, function ($item) {
                return ($item->getLevel() == Logger::LOGLEVEL_ERROR);
            })
        );
        return [$problems, $err];
    }
}
