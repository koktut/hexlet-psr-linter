<?php

namespace HexletPsrLinter\ReportBuilder;

/**
 * Interface ReportBaseInterface
 * @package HexletPsrLinter\Report
 */
interface ReportBaseInterface
{
    public function build($logger);
}
