<?php

namespace HexletPsrLinter\ReportBuilder;

/**
 * Class ReportJson
 * @package HexletPsrLinter\ReportBuilder
 */
class ReportJson implements ReportBaseInterface
{
    private $report;

    /**
     * ReportJson constructor.
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
        return json_encode($this->report);
    }
}
