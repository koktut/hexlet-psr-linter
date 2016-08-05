<?php

namespace HexletPsrLinter\ReportBuilder;

/**
 * Class ReportBulder
 * @package HexletPsrLinter\Report
 */
class ReportBulder implements ReportBaseInterface
{
    private $reports = [
        'txt' => ReportTxt::class,
        'json' => ReportJson::class,
        'yml' => ReportYml::class
    ];
    private $report;

    /**
     * ReportBaseInterface constructor.
     * @param $format
     */
    public function __construct($format)
    {
        if (!array_key_exists($format, $this->reports)) {
            $format = 'txt';
        }
        $this->report = new $this->reports[$format];
    }

    /**
     * @param $fileName
     * @param $logger
     * @return mixed|void
     */
    public function addSection($fileName, $logger)
    {
        $this->report->addSection($fileName, $logger);
    }

    /**
     * @return mixed
     */
    public function build()
    {
        return $this->report->build();
    }
}
