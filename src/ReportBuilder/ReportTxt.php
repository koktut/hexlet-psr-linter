<?php

namespace HexletPsrLinter\ReportBuilder;

/**
 * Class ReportTxt
 * @package HexletPsrLinter\ReportBuilder
 */
class ReportTxt implements ReportBaseInterface
{
    private $report;

    /**
     * ReportTxt constructor.
     */
    public function __construct()
    {
        $this->report = '';
    }

    /**
     * @param $sectioName
     * @param $logger
     * @return mixed
     */
    public function addSection($sectioName, $logger)
    {
        $index = 1;
        $this->report .= 'file: ' . $sectioName . PHP_EOL;
        foreach ($logger->toArray() as $record) {
            $this->report .=
                sprintf(
                    "%-4s %-7s%-10s%-60s%-30s",
                    $index++,
                    $record['line'] . ':' . $record['column'],
                    $logger->getLevelAsText($record['level']),
                    $record['message'],
                    $record['name']
                ) . PHP_EOL;
        }
    }

    /**
     * @return string
     */
    public function build()
    {
        return $this->report;
    }
}
