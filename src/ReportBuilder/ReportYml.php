<?php

namespace HexletPsrLinter\ReportBuilder;

use Symfony\Component\Yaml\Yaml;

/**
 * Class ReportYml
 * @package HexletPsrLinter\ReportBuilder
 */
class ReportYml implements ReportBaseInterface
{
    /**
     * @param $logger
     * @return string
     */
    public function build($logger)
    {
        $jsonArray = [];
        for ($index = 0; $index < $logger->getSize(); $index++) {
            $record = $logger->getRecord($index);
            $jsonArray [] = [
                $record->getLine() . ':' . $record->getLine(),
                $logger->getLevelAsText($record->getLevel()),
                $record->getMessage(),
                $record->getName()
            ];
        }
        return (new Yaml())->dump($jsonArray);
    }
}
