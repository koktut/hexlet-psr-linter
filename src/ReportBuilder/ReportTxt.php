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
        for ($index = 0; $index < $logger->getSize(); $index++) {
            $record = $logger->getRecord($index);
            $report .=
                sprintf(
                    "%d. %-7s%-10s%-60s%-30s",
                    $index + 1,
                    $record->getLine() . ':' . $record->getColumn(),
                    $logger->getLevelAsText($record->getLevel()),
                    $record->getMessage(),
                    $record->getName()
                ) . PHP_EOL;
        }

        return $report;
    }
}
