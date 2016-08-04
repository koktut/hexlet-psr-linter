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
        return (new Yaml())->dump($logger->toArray());
    }
}
