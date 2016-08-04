<?php

namespace HexletPsrLinter\ReportBuilder;

/**
 * Interface ReportBaseInterface
 * @package HexletPsrLinter\Report
 */
interface ReportBaseInterface
{
    /**
     * @param $sectioName
     * @param $logger
     * @return mixed
     */
    public function addSection($sectioName, $logger);

    public function build();
}
