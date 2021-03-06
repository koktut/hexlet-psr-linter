<?php

namespace HexletPsrLinter;

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
        if (is_file($srcPath)) {
            $targetFiles[] = $srcPath;
        }
    }

    return $targetFiles;
}
