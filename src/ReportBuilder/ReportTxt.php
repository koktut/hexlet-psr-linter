<?php

namespace HexletPsrLinter\ReportBuilder;

/**
 * Class ReportTxt
 * @package HexletPsrLinter\ReportBuilder
 */
class ReportTxt implements ReportBaseInterface
{

    /**
     * @param $logger
     * @return string
     */
    public function build($logger)
    {
        $report = '';
        $index = 1;
        foreach ($logger->toArray() as $record) {
            $report .=
                sprintf(
                    "%d. %-7s%-10s%-60s%-30s",
                    $index++,
                    $record['line'] . ':' . $record['column'],
                    $logger->getLevelAsText($record['level']),
                    $record['message'],
                    $record['name']
                ) . PHP_EOL;
        }

        return $report;
    }
}
