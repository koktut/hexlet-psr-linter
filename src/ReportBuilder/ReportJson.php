<?php

namespace HexletPsrLinter\ReportBuilder;

/**
 * Class ReportJson
 * @package HexletPsrLinter\ReportBuilder
 */
class ReportJson implements ReportBaseInterface
{

    /**
     * @param $logger
     * @return string
     */
    public function build($logger)
    {
        return json_encode($logger->toArray());
    }
}
