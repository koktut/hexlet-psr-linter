<?php

namespace HexletPsrLinter;

use PsrLinter;

use League\CLImate\CLImate;

/**
 * Class LinterApp
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

        $linter = new Linter\PsrLinter();

        foreach ($targetFiles as $target) {
            echo "Validate file: $target";
            $code = file_get_contents($target);
            $log = $linter->lint($code);
        }

        return 0;
    }

    private function printErrorMsg($message)
    {
        echo $message;
    }
}
