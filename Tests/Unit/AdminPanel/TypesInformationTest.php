<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\AdminPanel;

use Brotkrueml\Schema\AdminPanel\TypesInformation;
use Brotkrueml\Schema\Cache\PagesCacheService;
use Brotkrueml\Schema\Extension;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Adminpanel\ModuleApi\ModuleData;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

final class TypesInformationTest extends TestCase
{
    private PagesCacheService&Stub $pagesCacheServiceStub;
    private StandaloneView&MockObject $viewMock;
    private LanguageService&Stub $languageServiceStub;
    private TypesInformation $subject;

    protected function setUp(): void
    {
        $this->pagesCacheServiceStub = $this->createStub(PagesCacheService::class);

        $this->subject = new TypesInformation($this->pagesCacheServiceStub);

        $this->viewMock = $this->createMock(StandaloneView::class);
        $this->viewMock
            ->method('render')
            ->willReturn('');
        GeneralUtility::addInstance(StandaloneView::class, $this->viewMock);

        $this->languageServiceStub = $this->createStub(LanguageService::class);
        $GLOBALS['LANG'] = $this->languageServiceStub;
    }

    protected function tearDown(): void
    {
        unset($GLOBALS['LANG']);
        GeneralUtility::purgeInstances();
    }

    /**
     * @test
     */
    public function getIdentifierReturnsIdentifierCorrectly(): void
    {
        self::assertSame('ext-schema_types', $this->subject->getIdentifier());
    }

    /**
     * @test
     */
    public function getLabelReturnsLabelCorrectly(): void
    {
        $this->languageServiceStub
            ->method('sL')
            ->with(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.types')
            ->willReturn('Types');

        self::assertSame('Types', $this->subject->getLabel());
    }

    /**
     * @test
     * @dataProvider dataProviderForGetContent
     */
    public function getContentWithNoCacheEntryAvailable(?string $markupFromCache, array $expectedTypes): void
    {
        $this->pagesCacheServiceStub
            ->method('getMarkupFromCache')
            ->willReturn($markupFromCache ? \sprintf(Extension::JSONLD_TEMPLATE, $markupFromCache) : $markupFromCache);

        $this->viewMock
            ->expects(self::once())
            ->method('assign')
            ->with('types', $expectedTypes);

        $this->subject->getContent(new ModuleData());
    }

    public function dataProviderForGetContent(): \Iterator
    {
        yield 'No cache entry found, assign empty array to view' => [
            null,
            [],
        ];

        yield 'One type is available' => [
            '{"@context":"https://schema.org/","@type":"Thing","@id":"thingyId","description":"thingy description","name":"thingy name"}',
            [
                [
                    '@type' => 'Thing',
                    '@id' => 'thingyId',
                    'description' => 'thingy description',
                    'name' => 'thingy name',
                ],
            ],
        ];

        yield 'Two types are available' => [
            '{"@context":"https://schema.org/","@graph":[{"@type":"Action","name":"action name","url":"http://example.org/"},{"@type":"Person","@id":"personId","name":"person name","worksFor":"someone"}]}',
            [
                [
                    '@type' => 'Action',
                    'name' => 'action name',
                    'url' => 'http://example.org/',
                ],
                [
                    '@type' => 'Person',
                    '@id' => 'personId',
                    'name' => 'person name',
                    'worksFor' => 'someone',
                ],
            ],
        ];

        yield 'Types are sorted alphabetically' => [
            '{"@context":"https://schema.org/","@graph":[{"@type":"Thing","name":"A thing"},{"@type":"Event","name":"An event"},{"@type":"Person","name":"A person"}]}',
            [
                [
                    '@type' => 'Event',
                    'name' => 'An event',
                ],
                [
                    '@type' => 'Person',
                    'name' => 'A person',
                ],
                [
                    '@type' => 'Thing',
                    'name' => 'A thing',
                ],
            ],
        ];
    }
}
