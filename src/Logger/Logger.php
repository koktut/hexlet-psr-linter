<?php

namespace HexletPsrLinter\Logger;

/**
 * Class Logger
 * @package HexletPsrLinter\Logger
 */
class Logger
{
    const LOGLEVEL_WARNING = 1;
    const LOGLEVEL_ERROR = 2;
    const LOGLEVEL_FIXED = 3;

    private $log;

    /**
     * Logger constructor.
     */
    public function __construct()
    {
        $this->log = [];
    }

    /**
     * @param $level
     * @return mixed
     */
    public static function getLevelAsText($level)
    {
        $levelText = [
            self::LOGLEVEL_ERROR => 'error',
            self::LOGLEVEL_WARNING => 'warning',
            self::LOGLEVEL_FIXED => 'fixed'
        ];
        if (!key_exists($level, $levelText)) {
            return '';
        }
        return $levelText[$level];
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
        $this->log [] = $logRecord;
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
        $err = count(
            array_filter($this->log, function ($item) {
                return ($item->getLevel() == Logger::LOGLEVEL_ERROR);
            })
        );
        $warn = count(
            array_filter($this->log, function ($item) {
                return ($item->getLevel() == Logger::LOGLEVEL_WARNING);
            })
        );

        return ['err' =>$err, 'warn' => $warn];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $resArray = [];
        for ($index = 0; $index < $this->getSize(); $index++) {
            $record = $this->getRecord($index);
            $resArray[$index] = [
                'line' => $record->getLine(),
                'column' =>  $record->getColumn(),
                'level' => $record->getLevel(),
                'message' => $record->getMessage(),
                'name' => $record->getName(),
            ];
        }
        return $resArray;
    }
}
