<?php

namespace Brotkrueml\Schema\Tests\Unit\Generator\File;

use Brotkrueml\Schema\Generator\File\Reader;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;

class ReaderTest extends TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    protected $root;

    protected function setUp(): void
    {
        $this->root = vfsStream::setup('test-dir');
    }

    /**
     * @test
     */
    public function readReturnsTheContentCorrectly(): void
    {
        \file_put_contents(vfsStream::url('test-dir') . '/read-test.txt', 'read test content');

        $reader = new Reader(vfsStream::url('test-dir') . '/read-test.txt');
        $actual = $reader->read();

        self::assertSame('read test content', $actual);
    }

    /**
     * @test
     */
    public function readThrowsExceptionIfFileNotExisting(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Reader(vfsStream::url('test-dir') . '/not-existing.txt');
    }
}
