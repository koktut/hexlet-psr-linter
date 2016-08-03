<?php

namespace HexletPsrLinter\Logger;

/**
 * Class Logger
 * @package HexletPsrLinter\Logger
 */
class Logger
{
    const LOGLEVEL_ERROR = 2;
    const LOGLEVEL_WARNING = 1;

    private $levelText = [
        self::LOGLEVEL_ERROR => 'error',
        self::LOGLEVEL_WARNING => 'warning'
    ];
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
     * @return mixed
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
     * Clear log
     */
    public function clear()
    {
        $this->log = [];
    }

    /**
     * @return array
     */
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

    /**
     * @param $level
     * @return mixed
     */
    public function getLevelAsText($level)
    {
        if (!key_exists($level, $this->levelText)) {
            return '';
        }
        return $this->levelText[$level];
    }
}
