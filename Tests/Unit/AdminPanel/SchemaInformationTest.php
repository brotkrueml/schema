<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\AdminPanel;

use Brotkrueml\Schema\AdminPanel\SchemaInformation;
use Brotkrueml\Schema\Cache\PagesCacheService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Adminpanel\ModuleApi\ModuleData;
use TYPO3\CMS\Fluid\View\StandaloneView;

class SchemaInformationTest extends TestCase
{
    /** @var Stub|PagesCacheService */
    private $pagesCacheServiceStub;

    /** @var MockObject|StandaloneView */
    private $viewMock;

    /** @var SchemaInformation */
    private $subject;

    protected function setUp(): void
    {
        $this->pagesCacheServiceStub = $this->createStub(PagesCacheService::class);
        $this->viewMock = $this->createMock(StandaloneView::class);
        $this->viewMock
            ->method('render')
            ->willReturn('');

        $this->subject = new SchemaInformation($this->pagesCacheServiceStub);
        $this->subject->setView($this->viewMock);
    }

    /**
     * @test
     */
    public function getIdentifierReturnsIdentifierCorrectly(): void
    {
        self::assertSame('tx_schema_info', $this->subject->getIdentifier());
    }

    /**
     * @test
     */
    public function getLabelReturnsLabelCorrectly(): void
    {
        self::assertSame('Schema', $this->subject->getLabel());
    }

    /**
     * @test
     * @dataProvider dataProviderForGetContent
     * @param string|null $markupFromCache
     * @param array $expectedTypes
     */
    public function getContentWithNoCacheEntryAvailable(?string $markupFromCache, array $expectedTypes): void
    {
        $this->pagesCacheServiceStub
            ->method('getMarkupFromCache')
            ->willReturn($markupFromCache);

        $this->viewMock
            ->expects(self::once())
            ->method('assign')
            ->with('types', $expectedTypes);

        $this->subject->getContent(new ModuleData());
    }

    public function dataProviderForGetContent(): \Generator
    {
        yield 'No cache entry found, assign empty array to view' => [
            null,
            [],
        ];

        yield 'One type is available' => [
            '<script type="application/ld+json">{"@context":"http://schema.org","@type":"Thing","@id":"thingyId","description":"thingy description","name":"thingy name"}</script>',
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
            '<script type="application/ld+json">{"@context":"http://schema.org","@graph":[{"@type":"Action","name":"action name","url":"http://example.org/"},{"@type":"Person","@id":"personId","name":"person name","worksFor":"someone"}]}</script>',
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
            '<script type="application/ld+json">{"@context":"http://schema.org","@graph":[{"@type":"Thing","name":"A thing"},{"@type":"Event","name":"An event"},{"@type":"Person","name":"A person"}]}</script>',
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
