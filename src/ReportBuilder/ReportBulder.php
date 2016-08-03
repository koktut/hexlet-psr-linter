<?php

namespace HexletPsrLinter\ReportBuilder;

/**
 * Class ReportBulder
 * @package HexletPsrLinter\Report
 */
class ReportBulder
{
    private $reports = [
        'txt' => ReportTxt::class,
        'json' => ReportJson::class,
        'yml' => ReportYml::class
    ];

    /**
     * @param $format
     * @param $logger
     * @return mixed
     */
    public function buld($format, $logger)
    {
        if (!array_key_exists($format, $this->reports)) {
        }
        $report = new $this->reports[$format];
        return ($report->build($logger));
    }
}
