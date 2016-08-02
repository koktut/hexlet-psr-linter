<?php

namespace HexletPsrLinter;

use org\bovigo\vfs\vfsStream;

/**
 * Class FuntionsTest
 */
class FunctionsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetTargetFiles()
    {
        vfsStream::setup();
        $structure = [
            'src' => [
                '1.php' => '',
                '2.php' => '',
                '3.csv' => '',
            ],
            'src1' => [
                '4.php' => ''
            ]
        ];
        $root = vfsStream::create($structure);
        $rootPath = vfsStream::url($root->getName());
        $targets = getTargetFiles($rootPath);

        $this->assertEquals('vfs://root' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . '1.php', $targets[0]);
        $this->assertEquals('vfs://root' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . '2.php', $targets[1]);
        $this->assertEquals('vfs://root' . DIRECTORY_SEPARATOR . 'src1' . DIRECTORY_SEPARATOR . '4.php', $targets[2]);
    }
}
