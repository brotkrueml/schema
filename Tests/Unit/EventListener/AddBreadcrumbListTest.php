<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\EventListener;

use Brotkrueml\Schema\Configuration\Configuration;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Event\RenderAdditionalTypesEvent;
use Brotkrueml\Schema\EventListener\AddBreadcrumbList;
use Brotkrueml\Schema\JsonLd\Renderer;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type as FixtureType;
use Brotkrueml\Schema\Type\AdditionalPropertiesProvider;
use Brotkrueml\Schema\Type\TypeFactory;
use Brotkrueml\Schema\Type\TypeRegistry;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Http\Uri;
use TYPO3\CMS\Core\Routing\RouteResultInterface;
use TYPO3\CMS\Core\Routing\RouterInterface;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Frontend\Page\PageInformation;

#[CoversClass(AddBreadcrumbList::class)]
final class AddBreadcrumbListTest extends TestCase
{
    private RenderAdditionalTypesEvent $event;
    private PageInformation $pageInformation;
    private ServerRequestInterface&Stub $requestStub;
    private TypeFactory $typeFactory;

    protected function setUp(): void
    {
        $router = new class implements RouterInterface {
            public function matchRequest(ServerRequestInterface $request, ?RouteResultInterface $previousResult = null): RouteResultInterface
            {
                throw new \Exception('Should never be called!');
            }

            public function generateUri($route, array $parameters = [], string $fragment = '', string $type = self::ABSOLUTE_URL): UriInterface
            {
                return new Uri(\sprintf(
                    'https://example.org/page-%s-%s/',
                    $route['uid'],
                    $parameters['_language'],
                ));
            }
        };

        $language = new SiteLanguage(0, 'en-GB', new Uri('https://example.org/'), []);
        $this->pageInformation = new PageInformation();
        $site = self::createStub(Site::class);
        $site
            ->method('getRouter')
            ->willReturn($router);

        $this->requestStub = self::createStub(ServerRequestInterface::class);
        $this->requestStub
            ->method('getAttribute')
            ->willReturnCallback(fn(string $argument): PageInformation|SiteLanguage|Stub => match ($argument) {
                'frontend.page.information' => $this->pageInformation,
                'language' => $language,
                'site' => $site,
            });

        $this->event = new RenderAdditionalTypesEvent(
            false,
            false,
            $this->requestStub,
        );

        $typeRegistry = new TypeRegistry();
        $typeRegistry->addType('BreadcrumbList', FixtureType\BreadcrumbList::class);
        $typeRegistry->addType('ListItem', FixtureType\ListItem::class);
        $typeRegistry->addType('WebPage', FixtureType\WebPage::class);

        $this->typeFactory = new TypeFactory(new AdditionalPropertiesProvider(), $typeRegistry);
    }

    #[Test]
    public function noBreadcrumbIsAddedWhenItShouldNotBeEmbeddedViaConfiguration(): void
    {
        $configuration = $this->buildConfiguration(automaticBreadcrumbSchemaGeneration: false);

        $subject = new AddBreadcrumbList(
            $configuration,
            $this->typeFactory,
        );

        $subject->__invoke($this->event);

        self::assertSame([], $this->event->getAdditionalTypes());
    }

    #[Test]
    public function withEmptyRootLineNoBreadcrumbIsAdded(): void
    {
        $configuration = $this->buildConfiguration(automaticBreadcrumbSchemaGeneration: true);

        $subject = new AddBreadcrumbList(
            $configuration,
            $this->typeFactory,
        );

        $this->pageInformation->setRootLine([]);
        $subject->__invoke($this->event);

        self::assertSame([], $this->event->getAdditionalTypes());
    }

    #[Test]
    #[DataProvider('rootLineProvider')]
    public function breadcrumbIsAddedCorrectly(array $rootLine, string $expected): void
    {
        $configuration = $this->buildConfiguration(
            automaticBreadcrumbSchemaGeneration: true,
            automaticBreadcrumbExcludeAdditionalDoktypes: [42, 43],
        );

        $this->pageInformation->setRootLine($rootLine);

        $subject = new AddBreadcrumbList(
            $configuration,
            $this->typeFactory,
        );
        $subject->__invoke($this->event);

        $actual = $this->event->getAdditionalTypes();

        self::assertCount(1, $actual);
        self::assertSame($expected, $this->renderJsonLd($actual[0]));
    }

    public static function rootLineProvider(): iterable
    {
        yield 'Root line with nav_title set' => [
            'rootLine' => [
                [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => 'A nav title page',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            'expected' => '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/page-2-0/"},"name":"A nav title page","position":"1"}}',
        ];

        yield 'Root line with nav_hide set' => [
            'rootLine' => [
                [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 3,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '1',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            'expected' => '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/page-2-0/"},"name":"A page","position":"1"}}',
        ];

        yield 'Root line with a hidden page' => [
            'rootLine' => [
                [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 3,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'hidden' => '1',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            'expected' => '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/page-2-0/"},"name":"A page","position":"1"}}',
        ];

        yield 'Folder in root line should not be rendered' => [
            'rootLine' => [
                [
                    'uid' => 42,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_SYSFOLDER,
                    'title' => 'A folder',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            'expected' => '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/page-2-0/"},"name":"A page","position":"1"}}',
        ];

        yield 'Menu separator in root line should not be rendered, but doktype 198' => [
            'rootLine' => [
                [
                    'uid' => 42,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_SPACER,
                    'title' => 'A menu separator',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => 198,
                    'title' => 'A page with doktype 198',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            'expected' => '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/page-2-0/"},"name":"A page with doktype 198","position":"1"}}',
        ];

        yield 'Doktype 200 should be rendered' => [
            'rootLine' => [
                [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => 200,
                    'title' => 'A page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            'expected' => '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/page-2-0/"},"name":"A page","position":"1"}}',
        ];

        yield 'Doktype 43 (which is excluded via extension configuration) should not be rendered' => [
            'rootLine' => [
                [
                    'uid' => 1,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'Site root page',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '1',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 2,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page on level 1',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 3,
                    'doktype' => 43,
                    'title' => 'A page on level 2',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
                [
                    'uid' => 4,
                    'doktype' => PageRepository::DOKTYPE_DEFAULT,
                    'title' => 'A page on level 3',
                    'nav_title' => '',
                    'nav_hide' => '0',
                    'is_siteroot' => '0',
                    'tx_schema_webpagetype' => '',
                ],
            ],
            'expected' => '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/page-2-0/"},"name":"A page on level 1","position":"1"},{"@type":"ListItem","item":{"@type":"WebPage","@id":"https://example.org/page-4-0/"},"name":"A page on level 3","position":"2"}]}',
        ];
    }

    #[Test]
    public function breadcrumbIsAlreadyAvailabledAndAddedWhenOnlyOneIsAllowed(): void
    {
        $configuration = $this->buildConfiguration(
            automaticBreadcrumbSchemaGeneration: true,
            allowOnlyOneBreadcrumbList: true,
        );

        $subject = new AddBreadcrumbList(
            $configuration,
            $this->typeFactory,
        );

        $this->pageInformation->setRootLine([
            [
                'uid' => 1,
                'doktype' => PageRepository::DOKTYPE_DEFAULT,
                'title' => 'Site root page',
                'nav_title' => '',
                'nav_hide' => '0',
                'is_siteroot' => '1',
                'tx_schema_webpagetype' => '',
            ],
        ]);

        $event = new RenderAdditionalTypesEvent(false, true, $this->requestStub);
        $subject->__invoke($event);

        $actual = $this->event->getAdditionalTypes();

        self::assertSame([], $actual);
    }

    private function renderJsonLd(TypeInterface $type): string
    {
        $renderer = new Renderer();
        $renderer->addType($type);

        return $renderer->render();
    }

    #[Test]
    public function rootLineWithDifferentWebPageTypeSet(): never
    {
        self::markTestSkipped('Skipped, see https://github.com/brotkrueml/schema/issues/121');

        $configuration = $this->buildConfiguration(automaticBreadcrumbSchemaGeneration: true);

        $subject = new AddBreadcrumbList(
            $configuration,
            $this->typeFactory,
        );

        $this->pageInformation->setRootLine([
            [
                'uid' => 1,
                'doktype' => PageRepository::DOKTYPE_DEFAULT,
                'title' => 'Site root page',
                'nav_title' => '',
                'nav_hide' => '0',
                'is_siteroot' => '1',
                'tx_schema_webpagetype' => '',
            ],
            [
                'uid' => 2,
                'doktype' => PageRepository::DOKTYPE_DEFAULT,
                'title' => 'A page',
                'nav_title' => '',
                'nav_hide' => '0',
                'is_siteroot' => '0',
                'tx_schema_webpagetype' => 'ItemPage',
            ],
        ]);

        $subject->__invoke($this->event);

        $actual = $this->event->getAdditionalTypes();
        $expected = '{"@context":"https://schema.org/","@type":"BreadcrumbList","itemListElement":{"@type":"ListItem","item":{"@type":"ItemPage","@id":"https://example.org/page-2-0/"},"name":"A page","position":"1"}}';
        self::assertCount(1, $actual);
        self::assertSame($expected, $this->renderJsonLd($actual[0]));
    }

    private function buildConfiguration(
        bool $automaticBreadcrumbSchemaGeneration = false,
        array $automaticBreadcrumbExcludeAdditionalDoktypes = [],
        bool $allowOnlyOneBreadcrumbList = false,
    ): Configuration {
        return new Configuration(
            false,
            $automaticBreadcrumbSchemaGeneration,
            $automaticBreadcrumbExcludeAdditionalDoktypes,
            $allowOnlyOneBreadcrumbList,
            false,
            false,
        );
    }
}
