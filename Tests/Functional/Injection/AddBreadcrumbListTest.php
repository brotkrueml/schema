<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional\Injection;

use Brotkrueml\Schema\Injection\AddBreadcrumbList;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

#[CoversClass(AddBreadcrumbList::class)]
final class AddBreadcrumbListTest extends FunctionalTestCase
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

    /**
     * @var array<string, string>
     */
    protected array $pathsToLinkInTestInstance = [
        'typo3conf/ext/schema/Tests/Functional/Fixtures/Sites/' => 'typo3conf/sites',
    ];

    /**
     * @var array<string, array<string, array<string, string>>>
     */
    protected array $configurationToUseInTestInstance = [
        'EXTENSIONS' => [
            'schema' => [
                'automaticBreadcrumbSchemaGeneration' => '1',
                'automaticWebPageSchemaGeneration' => '1',
                'embedMarkupOnNoindexPages' => '0',
            ],
        ],
    ];

    #[Test]
    public function breadcrumbMarkupIsRenderedCorrectlyWithMultipleSubpages(): void
    {
        $this->importCSVDataSet(__DIR__ . '/../Fixtures/AddBreadcrumbList.csv');
        $this->setUpFrontendRootPage(
            1,
            [],
            [
                'config' => <<< TYPOSCRIPT
page = PAGE
page.10 = TEXT
TYPOSCRIPT,
            ],
        );
        $request = (new InternalRequest())->withPageId(4);

        $actual = (string) $this->executeFrontendSubRequest($request)->getBody();

        self::assertStringContainsString(
            '{"@context":"https://schema.org/","@type":"WebPage","breadcrumb":{"@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","item":{"@type":"WebPage","@id":"http://localhost/level-1.html"},"name":"level 1","position":"1"},{"@type":"ListItem","item":{"@type":"WebPage","@id":"http://localhost/level-2.html"},"name":"level 2","position":"2"},{"@type":"ListItem","item":{"@type":"WebPage","@id":"http://localhost/level-3.html"},"name":"level 3","position":"3"}]}}',
            $actual,
        );
    }
}
