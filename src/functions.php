<?php

namespace PsrLinter;

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

/**
 * Заготовка для обработки правил
 * @param $className
 * @return array
 */
function getRulesMethods($className)
{
    $reflector = new \ReflectionClass($className);
    $rulesMethods = [];
    foreach ($reflector->getMethods() as $method) {
        if ($method->isPublic() && strpos($method->getName(), 'get') === 0) {
            $rulesMethods [] = $method->getName();
        }
    }
    return $rulesMethods;
}
