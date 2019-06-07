<?php

namespace Brotkrueml\Schema\Tests\Unit\Generator\File;

use Brotkrueml\Schema\Generator\File\Writer;
use org\bovigo\vfs\{vfsStream, vfsStreamDirectory};
use PHPUnit\Framework\TestCase;

class WriterTest extends TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    protected $root;

    public function setUp(): void
    {
        $this->root = vfsStream::setup('test-dir');
    }

    /**
     * @test
     */
    public function writeOutputsTheCorrectContentWithPlaceholdersSubstituted()
    {
        $templatePathAndFileName = vfsStream::url('test-dir') . '/template.txt';
        $outputPath = vfsStream::url('test-dir') . '/output/';

        $template = <<<EOF
###COMMENT###
###VERSION###
###MODEL_CLASS###
###MODEL_EXTENDS###
###MODEL_PROPERTIES###
###VIEWHELPER_CLASS###
###VIEWHELPER_EXTENDS###
###VIEWHELPER_ARGUMENTS###
EOF;

        \file_put_contents($templatePathAndFileName, $template);

        $writer = new Writer($templatePathAndFileName, $outputPath);
        $resultForSetPlaceholders = $writer->setPlaceholders([
            '###COMMENT###' => 'This is the test comment',
            '###VERSION###' => '3.6',
            '###MODEL_CLASS###' => 'TestModel',
            '###MODEL_EXTENDS###' => 'AbstractType',
            '###MODEL_PROPERTIES###' => 'model properties',
            '###VIEWHELPER_CLASS###' => 'TestViewHelper',
            '###VIEWHELPER_EXTENDS###' => 'AbstractTypeViewHelper',
            '###VIEWHELPER_ARGUMENTS###' => 'view helper arguments',
        ]);

        $this->assertInstanceOf(Writer::class, $resultForSetPlaceholders);

        $writer->write('OutputTest');

        $actual = \file_get_contents($outputPath . 'OutputTest.php');

        $expected = <<<EOF
This is the test comment
3.6
TestModel
AbstractType
model properties
TestViewHelper
AbstractTypeViewHelper
view helper arguments
EOF;

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function givenClassSuffixInConstructorIsUsedCorrectly()
    {
        $templatePathAndFileName = vfsStream::url('test-dir') . '/template.txt';
        $outputPath = vfsStream::url('test-dir') . '/output/';

        \file_put_contents($templatePathAndFileName, '');

        $writer = new Writer($templatePathAndFileName, $outputPath, 'Suffix');
        $writer->write('OutputTest');

        $this->assertFileExists($outputPath . 'OutputTestSuffix.php');
    }

    /**
     * @test
     */
    public function exceptionThrownIfTemplatePathDoesNotExist()
    {
        $this->expectException(\InvalidArgumentException::class);

        $templatePathAndFileName = vfsStream::url('test-dir') . '/not-existing.txt';
        $outputPath = vfsStream::url('test-dir') . '/output/';

        new Writer($templatePathAndFileName, $outputPath);
    }
}
