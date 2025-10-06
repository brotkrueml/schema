<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional\Cache;

use Brotkrueml\Schema\Cache\MarkupCacheHandler;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Cache\CacheDataCollector;
use TYPO3\CMS\Core\Cache\CacheTag;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Frontend\Cache\CacheInstruction;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(MarkupCacheHandler::class)]
final class MarkupCacheHandlerTest extends FunctionalTestCase
{
    /**
     * @var list<string>
     */
    protected array $coreExtensionsToLoad = [
        'typo3/cms-adminpanel',
    ];

    /**
     * @var list<string>
     */
    protected array $testExtensionsToLoad = [
        'brotkrueml/schema',
    ];

    private MarkupCacheHandler $subject;

    protected function setUp(): void
    {
        parent::setup();

        /** @var FrontendInterface $runtimeCache */
        $runtimeCache = $this->get('cache.runtime');
        $runtimeCache->set('tx_schema_page_cache_identifier', 'some-page-cache-identifier');

        $this->subject = $this->get(MarkupCacheHandler::class);
    }

    #[Test]
    public function getMarkupReturnsNullWhenNoMarkupIsStored(): void
    {
        $actual = $this->subject->getMarkup();

        self::assertNull($actual);
    }

    #[Test]
    public function getMarkupReturnsMarkupFromPersistentCacheCorrectly(): void
    {
        $requestStub = self::createStub(ServerRequestInterface::class);
        $requestStub
            ->method('getAttribute')
            ->willReturnMap([
                [
                    'frontend.cache.instruction',
                    new CacheInstruction(),
                ],
                [
                    'frontend.cache.collector',
                    new CacheDataCollector(),
                ],
            ]);

        $this->subject->storeMarkup('some-markup', $requestStub);

        $actual = $this->subject->getMarkup();

        self::assertSame('some-markup', $actual);
    }

    #[Test]
    public function getMarkupReturnsMarkupFromRuntimeCacheCorrectly(): void
    {
        $cacheInstruction = new CacheInstruction();
        $cacheInstruction->disableCache('for testing');

        $requestStub = self::createStub(ServerRequestInterface::class);
        $requestStub
            ->method('getAttribute')
            ->willReturnMap([
                [
                    'frontend.cache.instruction',
                    $cacheInstruction,
                ],
                [
                    'frontend.cache.collector',
                    new CacheDataCollector(),
                ],
            ]);

        $this->subject->storeMarkup('some-markup', $requestStub);

        $actual = $this->subject->getMarkup();

        self::assertSame('some-markup', $actual);
    }

    #[Test]
    public function storeMarkupStoresMarkupinPersistentCacheCorrectly(): void
    {
        $currentTimeStamp = \time();

        $cacheDataCollector = new CacheDataCollector();
        $cacheDataCollector->addCacheTags(new CacheTag('some-tag'));
        $cacheDataCollector->addCacheTags(new CacheTag('another-tag'));
        $cacheDataCollector->restrictMaximumLifetime(60);

        $requestStub = self::createStub(ServerRequestInterface::class);
        $requestStub
            ->method('getAttribute')
            ->willReturnMap([
                [
                    'frontend.cache.instruction',
                    new CacheInstruction(),
                ],
                [
                    'frontend.cache.collector',
                    $cacheDataCollector,
                ],
            ]);

        $this->subject->storeMarkup('some-markup', $requestStub);

        $connectionPool = $this->getConnectionPool();
        $cacheTableRows = $connectionPool
            ->getConnectionForTable('cache_tx_schema')
            ->select(
                ['*'],
                'cache_tx_schema',
                [
                    'identifier' => 'some-page-cache-identifier',
                ],
            )
            ->fetchAllAssociative();

        self::assertCount(1, $cacheTableRows);
        // We can't "mock" the time, so we check, if the max lifetime is within reasonable constraints
        self::assertGreaterThan($currentTimeStamp + 40, $cacheTableRows[0]['expires']);
        self::assertLessThan($currentTimeStamp + 70, $cacheTableRows[0]['expires']);

        $cacheTagsRows = $connectionPool
            ->getConnectionForTable('cache_tx_schema_tags')
            ->select(
                ['*'],
                'cache_tx_schema_tags',
                [
                    'identifier' => 'some-page-cache-identifier',
                ],
            )
            ->fetchAllAssociative();

        self::assertCount(2, $cacheTagsRows);
        $tags = \array_map(static fn(array $row): string => $row['tag'], $cacheTagsRows);
        self::assertContains('some-tag', $tags);
        self::assertContains('another-tag', $tags);
    }
}
