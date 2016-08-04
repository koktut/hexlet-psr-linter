<?php

namespace HexletPsrLinter;

use HexletPsrLinter\Linter\DefaultRules;
use PsrLinter;
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
        $autoFix = $params['fix'];
        $reportFormat = $params['format'];

        $targetFiles = getTargetFiles($srcPath);

        $rules = [DefaultRules::class];

        $linter = new Linter\PsrLinterVisitor($rules);

        $exitVal = 0;
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
        $stat = $logger->getStatistics();
        $err = $stat['err'];
        $warn = $stat['warn'];
        $problems = $err + $warn;
        $this->cli->lightRed("$problems problems ($err errors, $warn warnings)");
    }

    /**
     * @param $logRecord - Instance of LogRecord
     */
    private function printLogItem($logRecord)
    {
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
            case Logger::LOGLEVEL_FIXED:
                $this->cli->lightGreen()->inline(sprintf($format, $text));
                break;
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
