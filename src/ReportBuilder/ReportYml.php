<?php

namespace HexletPsrLinter\ReportBuilder;

use Symfony\Component\Yaml\Yaml;

/**
 * Class ReportYml
 * @package HexletPsrLinter\ReportBuilder
 */
class ReportYml implements ReportBaseInterface
{
    private $report;

    /**
     * ReportYml constructor.
     */
    public function __construct()
    {
        $this->report = [];
    }

    /**
     * @param $sectioName
     * @param $logger
     * @return mixed
     */
    public function addSection($sectioName, $logger)
    {
        $this->report [] = [
            'file' => $sectioName,
            'problems' => $logger->toArray()
        ];
    }

    /**
     * @return string
     */
    public function build()
    {
        return (new Yaml())->dump($this->report, INF);
    }
}
