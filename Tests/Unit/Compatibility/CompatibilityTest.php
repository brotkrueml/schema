<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Compatibility;

use Brotkrueml\Schema\Compatibility\Compatibility;
use PHPUnit\Framework\TestCase;

class CompatibilityTest extends TestCase
{
    /**
     * @var Compatibility
     */
    protected $subject;

    /**
     * @var int
     */
    protected static $version;

    public static function setUpBeforeClass(): void
    {
        /** @noinspection PhpUnusedLocalVariableInspection */
        $_EXTKEY = 'core';
        include __DIR__ . '/../../../.Build/web/typo3/sysext/core/ext_emconf.php';
        $version = \array_pop($EM_CONF)['version'];
        [$majorVersion] = explode('.', $version);

        static::$version = (int)$majorVersion;
    }

    protected function setUp(): void
    {
        $this->subject = new Compatibility();
    }

    /**
     * @test
     */
    public function hasCachePrefixForCacheIdentifierReturnsTrueOnVersion9(): void
    {
        if (static::$version > 9) {
            self::markTestSkipped('Skipped, running on version ' . static::$version);
        }

        self::assertTrue($this->subject->hasCachePrefixForCacheIdentifier());
    }

    /**
     * @test
     */
    public function hasCachePrefixForCacheIdentifierReturnsFalseOnVersion10AndUp(): void
    {
        if (static::$version < 10) {
            self::markTestSkipped('Skipped, running on version ' . static::$version);
        }

        self::assertFalse($this->subject->hasCachePrefixForCacheIdentifier());
    }

    /**
     * @test
     */
    public function isPsr14EventDispatcherAvailableReturnsFalseOnVersion9(): void
    {
        if (static::$version > 9) {
            self::markTestSkipped('Skipped, running on version ' . static::$version);
        }

        self::assertFalse($this->subject->isPsr14EventDispatcherAvailable());
    }

    /**
     * @test
     */
    public function isPsr14EventDispatcherAvailableReturnsTrueOnVersion10AndUp(): void
    {
        if (static::$version < 10) {
            self::markTestSkipped('Skipped, running on version ' . static::$version);
        }

        self::assertTrue($this->subject->isPsr14EventDispatcherAvailable());
    }
}
