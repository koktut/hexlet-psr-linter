<?php

namespace HexletPsrLinter;

$a_A = 1;

/**
 * @param $srcPath
 * @return array
 */
function getTargetFiles($srcPath)
{
    $targetFiles = [];
    if (is_dir($srcPath)) {
        $iter = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($srcPath, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iter as $path) {
            if ($path->isFile() && $path->getExtension() == 'php') {
                $targetFiles[] = $path->getPathname();
            }
        }
    } else {
        $targetFiles[] = $srcPath;
    }

    return $targetFiles;
}
