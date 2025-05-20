<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional\Caching;

use Brotkrueml\Schema\Caching\CacheIdentifierCreator;
use Brotkrueml\Schema\Caching\PersistentCacheHandler;
use Brotkrueml\Schema\Extension;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Stub;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class PersistentCacheHandlerTest extends FunctionalTestCase
{
    protected array $coreExtensionsToLoad = [
        'adminpanel',
    ];

    protected array $testExtensionsToLoad = [
        'brotkrueml/schema',
    ];

    private ServerRequestInterface&Stub $requestDummy;
    private PersistentCacheHandler $subject;

    protected function setUp(): void
    {
        parent::setUp();

        $this->requestDummy = self::createStub(ServerRequestInterface::class);

        $cacheIdentifierCreatorStub = self::createStub(CacheIdentifierCreator::class);
        $cacheIdentifierCreatorStub
            ->method('getCacheIdentifier')
            ->with($this->requestDummy)
            ->willReturn('abc123');

        $this->subject = new PersistentCacheHandler(
            $cacheIdentifierCreatorStub,
            $this->get(Extension::CACHE_SERVICE_ID),
        );
    }

    #[Test]
    public function cacheEntryIsNotAvailableThenNullIsReturned(): void
    {
        $actual = $this->subject->getMarkup($this->requestDummy);

        self::assertNull($actual);
    }

    #[Test]
    public function cacheEntryIsAvailableThenTheEntryIsReturnedCorrectly(): void
    {
        /** @var FrontendInterface $cache */
        $cache = $this->get(Extension::CACHE_SERVICE_ID);
        $cache->set('abc123', 'some-markup');

        $actual = $this->subject->getMarkup($this->requestDummy);

        self::assertSame('some-markup', $actual);
    }
}
