<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\AdminPanel;

use Brotkrueml\Schema\AdminPanel\SchemaModule;
use Brotkrueml\Schema\Cache\PagesCacheService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Localization\LanguageService;

#[CoversClass(SchemaModule::class)]
final class SchemaModuleTest extends TestCase
{
    private PagesCacheService&Stub $pagesCacheService;
    private SchemaModule $subject;

    protected function setUp(): void
    {
        if ((new Typo3Version())->getMajorVersion() < 12) {
            self::markTestSkipped('Skip tests for TYPO3 version 11, as there is more configuration necessary.');
        }

        $this->pagesCacheService = self::createStub(PagesCacheService::class);
        $this->subject = new SchemaModule($this->pagesCacheService);

        $languageService = self::createStub(LanguageService::class);
        $languageService
            ->method('sL')
            ->willReturnMap([
                ['LLL:EXT:schema/Resources/Private/Language/locallang.xlf:adminPanel.type', 'Type'],
                ['LLL:EXT:schema/Resources/Private/Language/locallang.xlf:adminPanel.types', 'Types'],
            ]);
        $GLOBALS['LANG'] = $languageService;
    }

    protected function tearDown(): void
    {
        unset($GLOBALS['LANG']);
    }

    #[Test]
    public function getIconIdentifier(): void
    {
        self::assertSame('ext-schema-module-adminpanel', $this->subject->getIconIdentifier());
    }

    #[Test]
    public function getIdentifier(): void
    {
        self::assertSame('ext-schema', $this->subject->getIdentifier());
    }

    #[Test]
    public function getLabel(): void
    {
        self::assertSame('Schema', $this->subject->getLabel());
    }

    #[Test]
    #[DataProvider('providerForGetShortInfo')]
    public function getShortInfo(?string $markupFromCache, string $expected): void
    {
        $this->pagesCacheService
            ->method('getMarkupFromCache')
            ->willReturn($markupFromCache);

        $actual = $this->subject->getShortInfo();

        self::assertSame($expected, $actual);
    }

    public static function providerForGetShortInfo(): iterable
    {
        yield 'with null returned from cache' => [
            'markupFromCache' => null,
            'expected' => '(0 Types)',
        ];

        yield 'with one item returned from cache' => [
            'markupFromCache' => '{"@context":"https://schema.org/","@type":"GenericStub","@id":"some-id"}',
            'expected' => '(1 Type)',
        ];

        yield 'with one item as graph returned from cache' => [
            'markupFromCache' => '{"@context":"https://schema.org/","@graph":[{"@type":"GenericStub","@id":"some-id"}]}',
            'expected' => '(1 Type)',
        ];

        yield 'with two items as graph returned from cache' => [
            'markupFromCache' => '{"@context":"https://schema.org/","@graph":[{"@type":"GenericStub","@id":"some-id"},{"@type":"GenericStub","@id":"another-id"}]}',
            'expected' => '(2 Types)',
        ];
    }
}
