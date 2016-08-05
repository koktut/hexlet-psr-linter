<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Linter\Loader\RulesLoader;
use HexletPsrLinter\Linter\Rules\DefaultRules;
use HexletPsrLinter\Logger\Logger;
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
        $rulesPath = $params[1];
        $autoFix = $params['fix'];
        $makeReport = $params['report'];
        $reportFormat = $params['format'];
        $reportFileName = $params['output'];

        $rulesLoader = new RulesLoader();
        $rules = $rulesLoader->loadRules($rulesPath);
        $this->cli->lightGreen("Loading rules:");
        $this->printLog($rulesLoader->getLog());
        $this->cli->out('');
        if ($rules == []) {
            $this->printErrorMsg('No rules found');
            return 1;
        }

        $linter = new Linter\PsrLinter($rules);

        $reportBuilder = new ReportBuilder\ReportBulder($reportFormat);

        $exitVal = 0;

        $targetFiles = getTargetFiles($srcPath);
        foreach ($targetFiles as $target) {
            if (!file_exists($target)) {
                $this->printErrorMsg("File not found: $target");
                $exitVal = 1;
                continue;
            }

            $code = file_get_contents($target);

            $logger = $linter->lint($code, $autoFix);

            if ($autoFix) {
                $prettyCode = $linter->getPrettyCode();
                file_put_contents($target, '<?php' . PHP_EOL . $prettyCode);
            }

            if ($logger->getSize() != 0) {
                $this->cli->lightGreen("$target");
                $this->cli->br();
                $this->printLog($logger);
                $this->cli->br();
                $this->printLogStat($logger);
                $this->cli->br();

                $exitVal = 1;
            }

            if ($makeReport === true && $logger->getSize() != 0) {
                $reportBuilder->addSection($target, $logger);
            }
        }

        if ($makeReport === true) {
            file_put_contents($reportFileName, $reportBuilder->build());
        }

        return $exitVal;
    }


    /**
     * @param $logger - Instance of Logger
     */
    private function printLog($logger)
    {
        $maxLen = 0;
        for ($i = 0; $i < $logger->getSize(); $i++) {
            $message = $logger->getRecord($i)->getMessage();
            $maxLen = $maxLen < strlen($message) ? strlen($message) : $maxLen;
        }

        for ($i = 0; $i < $logger->getSize(); $i++) {
            $this->printLogItem($logger->getRecord($i), $maxLen);
        }
    }

    /**
     * @param $logger - Instance of Logger
     */
    private function printLogStat($logger)
    {
        $stat = $logger->getStatistics();
        $err = $stat['err'];
        $warn = $stat['warn'];
        $problems = $err + $warn;
        $this->cli->lightRed("$problems problems ($err errors, $warn warnings)");
    }

    /**
     * @param $logRecord - Instance of LogRecord
     */
    private function printLogItem($logRecord, $maxMessageLen)
    {
        $maxMessageLen += 2;
        $this->cli->lightGray()->inline(sprintf('%-7s', $logRecord->getLine() . ':' . $logRecord->getColumn()));
        $format = '%-10s';
        $text = Logger::getLevelAsText($logRecord->getLevel());
        switch ($logRecord->getLevel()) {
            case Logger::LOGLEVEL_ERROR:
                $this->cli->lightRed()->inline(sprintf($format, $text));
                break;
            case Logger::LOGLEVEL_WARNING:
                $this->cli->lightYellow()->inline(sprintf($format, $text));
                break;
            default:
                $this->cli->lightGreen()->inline(sprintf($format, $text));
                break;
        }
        $this->cli
            ->white()->inline(sprintf("%-{$maxMessageLen}s", $logRecord->getMessage()))
            ->lightGray()->inline(sprintf("%s", $logRecord->getName()))
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
