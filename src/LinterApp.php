<?php

namespace HexletPsrLinter;

use PsrLinter;
use HexletPsrLinter\Logger\Logger;
use HexletPsrLinter\Linter\Rules;
use League\CLImate\CLImate;

/**
 * Class LinterApp
 * @codeCoverageIgnore
 */
class LinterApp
{
    private $cli;

    /**
     * LinterApp constructor.
     */
    public function __construct()
    {
        $this->cli = new CLImate();
    }

    /**
     * @param $params
     * @return int
     */
    public function run($params)
    {
        $srcPath = $params[0];

        $targetFiles = getTargetFiles($srcPath);

        /*if (is_null($params['format'])) {
            $this->outFormat = 'text';
        }*/

        $linter = new Linter\PsrLinterVisitor(new Rules());

        $exitVal = 0;
        foreach ($targetFiles as $target) {
            if (!file_exists($target)) {
                $this->printErrorMsg("File not found: $target");
                $exitVal = 1;
                continue;
            }

            $code = file_get_contents($target);

            $logger = $linter->lint($code);

            if ($logger->getSize() != 0) {
                $this->cli->green("$target");
                $this->cli->br();
                $this->printLog($logger);
                $this->cli->br();
                $this->printLogStat($logger);
                $this->cli->br();
                
                $exitVal = 1;
            }
        }

        return $exitVal;
    }

    /**
     * @param $logger - Instance of Logger
     */
    private function printLog($logger)
    {
        for ($i = 0; $i < $logger->getSize(); $i++) {
            $this->printLogItem($logger->getRecord($i));
        }
    }

    /**
     * @param $logger - Instance of Logger
     */
    private function printLogStat($logger)
    {
        list($problems, $err) = $logger->getStatistics();
        $warn = $problems - $err;
        $this->cli->lightRed("$problems problems ($err errors, $warn warnings)");
    }

    /**
     * @param $logRecord - Instance of LogRecord
     */
    private function printLogItem($logRecord)
    {
        $this->cli->lightGray()->inline(sprintf('%-7s', $logRecord->getLine() . ':' . $logRecord->getColumn()));
        switch ($logRecord->getLevel()) {
            case Logger::LOGLEVEL_ERROR:
                $this->cli->lightRed()->inline(sprintf('%-10s', 'error'));
                break;
            case Logger::LOGLEVEL_WARNING:
                $this->cli->lightYellow()->inline(sprintf('%-10s', 'waring'));
                break;
            default:
                $this->cli->yellow('error');
        }
        $this->cli
            ->white()->inline(sprintf("%-60s", $logRecord->getMessage()))
            ->lightGray()->inline(sprintf("%-30s", $logRecord->getName()))
            ->br();
    }

    /**
     * @param $message
     */
    private function printErrorMsg($message)
    {
        $this->cli->error($message);
    }
}
