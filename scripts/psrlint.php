#!/usr/bin/env php
<?php

namespace PsrLinter;

require_once __DIR__ . '/../vendor/autoload.php';

use Commando\Command;

$cmd = new Command();
$cmd->beepOnError(false);

$cmd->option()
    ->require(true)
    ->describedAs('Target path');
$cmd->option('format')
    ->description('Report file format')
    ->must(function ($format) {
        $formats = array('text', 'json', 'yml');
        return in_array($format, $formats);
    });

$cmd->option('fix')
    ->description('Auto fix names (my_var_name -> MyVarName)')
    ->boolean();

$app = new LinterApp();
exit($app->run($cmd));
