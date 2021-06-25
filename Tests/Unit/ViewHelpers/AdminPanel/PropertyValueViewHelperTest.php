<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\ViewHelpers\AdminPanel;

use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Tests\Unit\ViewHelpers\ViewHelperTestCase;
use Brotkrueml\Schema\ViewHelpers\AdminPanel\PropertyValueViewHelper;
use PHPUnit\Framework\MockObject\Stub;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Localization\LanguageService;

class PropertyValueViewHelperTest extends ViewHelperTestCase
{
    /** @var Stub|LanguageService */
    protected $languageServiceStub;

    /** @var Stub|Icon */
    protected $iconStub;

    protected function setUp(): void
    {
        parent::setUp();

        $this->languageServiceStub = $this->createStub(LanguageService::class);
        $GLOBALS['LANG'] = $this->languageServiceStub;

        $this->iconStub = $this->createStub(Icon::class);
        $this->iconStub
            ->method('render')
            ->willReturn('stubbed icon');
        $iconFactoryStub = $this->createStub(IconFactory::class);
        $iconFactoryStub
            ->method('getIcon')
            ->willReturn($this->iconStub);

        PropertyValueViewHelper::setIconFactory($iconFactoryStub);
    }

    protected function tearDown(): void
    {
        unset($GLOBALS['LANG']);
        parent::tearDown();
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function viewHelperReturnsOutputCorrectly(
        string $template,
        string $expected,
        string $localisedInput = '',
        string $localisedOutput = ''
    ): void {
        if ($localisedInput !== '') {
            $this->languageServiceStub
                ->method('sL')
                ->with(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.' . $localisedInput)
                ->willReturn($localisedOutput);
        }

        $actual = $this->renderTemplate($template);

        self::assertSame($expected, $actual);
    }

    public function dataProvider(): \Iterator
    {
        yield 'when value is an array, an empty string is returned' => [
            '<schema:adminPanel.propertyValue name="some-property" value="{0: \'some-value\'}"/>',
            '',
        ];

        yield '@id value is returned unchanged' => [
            '<schema:adminPanel.propertyValue name="@id" value="some-id"/>',
            'some-id',
        ];

        yield '@id value is htmlspecialchar\'d' => [
            '<schema:adminPanel.propertyValue name="@id" value="some&\"<id>"/>',
            'some&amp;&quot;&lt;id&gt;',
        ];

        yield '@type is linked to schema.org documentation' => [
            '<schema:adminPanel.propertyValue name="@type" value="Thing"/>',
            '<a href="https://schema.org/Thing" title="Open documentation on schema.org" target="_blank" rel="noreferrer">stubbed icon</a> Thing',
            'openDocumentationOnSchemaOrg',
            'Open documentation on schema.org',
        ];

        yield '@type value is htmlspecialchar\'d' => [
            '<schema:adminPanel.propertyValue name="@type" value="Th&ing"/>',
            '<a href="https://schema.org/Th&amp;ing" title="Open &quot;documentation&quot; on schema.org" target="_blank" rel="noreferrer">stubbed icon</a> Th&amp;ing',
            'openDocumentationOnSchemaOrg',
            'Open "documentation" on schema.org',
        ];

        yield 'value is returned unchanged if not a URL' => [
            '<schema:adminPanel.propertyValue name="some-name" value="some-property"/>',
            'some-property',
        ];

        yield 'value id returned unchanged if not a http(s) URL' => [
            '<schema:adminPanel.propertyValue name="some-name" value="ftp://example.org/"/>',
            'ftp://example.org/',
        ];

        yield 'value is htmlspecialchar\'d if not a URL' => [
            '<schema:adminPanel.propertyValue name="some-name" value="some <property>"/>',
            'some &lt;property&gt;',
        ];

        yield 'value is a schema.org URL with http' => [
            '<schema:adminPanel.propertyValue name="some-name" value="https://schema.org/Thing"/>',
            '<a href="https://schema.org/Thing" title="Open documentation on schema.org" target="_blank" rel="noreferrer">stubbed icon</a> https://schema.org/Thing',
            'openDocumentationOnSchemaOrg',
            'Open documentation on schema.org',
        ];

        yield 'value is a schema.org URL with https' => [
            '<schema:adminPanel.propertyValue name="some-name" value="https://schema.org/Thing"/>',
            '<a href="https://schema.org/Thing" title="Open documentation on schema.org" target="_blank" rel="noreferrer">stubbed icon</a> https://schema.org/Thing',
            'openDocumentationOnSchemaOrg',
            'Open documentation on schema.org',
        ];

        yield 'value is a gif image and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.gif"/>',
            '<a href="http://example.org/image.gif" title="Show image" target="_blank" rel="noreferrer">stubbed icon</a> http://example.org/image.gif',
            'showImage',
            'Show image',
        ];

        yield 'value is a jpg image and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.jpg"/>',
            '<a href="http://example.org/image.jpg" title="Show image" target="_blank" rel="noreferrer">stubbed icon</a> http://example.org/image.jpg',
            'showImage',
            'Show image',
        ];

        yield 'value is a jpeg image and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.jpeg"/>',
            '<a href="http://example.org/image.jpeg" title="Show image" target="_blank" rel="noreferrer">stubbed icon</a> http://example.org/image.jpeg',
            'showImage',
            'Show image',
        ];

        yield 'value is a png image and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.png"/>',
            '<a href="http://example.org/image.png" title="Show image" target="_blank" rel="noreferrer">stubbed icon</a> http://example.org/image.png',
            'showImage',
            'Show image',
        ];

        yield 'value is a svg image and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="https://example.org/image.svg"/>',
            '<a href="https://example.org/image.svg" title="Show image" target="_blank" rel="noreferrer">stubbed icon</a> https://example.org/image.svg',
            'showImage',
            'Show image',
        ];

        yield 'value is a gif image with uppercase extension and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.GIF"/>',
            '<a href="http://example.org/image.GIF" title="Show image" target="_blank" rel="noreferrer">stubbed icon</a> http://example.org/image.GIF',
            'showImage',
            'Show image',
        ];

        yield 'value is a jpg image with uppercase extension and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.JPG"/>',
            '<a href="http://example.org/image.JPG" title="Show image" target="_blank" rel="noreferrer">stubbed icon</a> http://example.org/image.JPG',
            'showImage',
            'Show image',
        ];

        yield 'value is a jpeg image with uppercase extension and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.JPEG"/>',
            '<a href="http://example.org/image.JPEG" title="Show image" target="_blank" rel="noreferrer">stubbed icon</a> http://example.org/image.JPEG',
            'showImage',
            'Show image',
        ];

        yield 'value is a png image with uppercase extension and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.PNG"/>',
            '<a href="http://example.org/image.PNG" title="Show image" target="_blank" rel="noreferrer">stubbed icon</a> http://example.org/image.PNG',
            'showImage',
            'Show image',
        ];

        yield 'value is a svg image with uppercase extension and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="https://example.org/image.SVG"/>',
            '<a href="https://example.org/image.SVG" title="Show image" target="_blank" rel="noreferrer">stubbed icon</a> https://example.org/image.SVG',
            'showImage',
            'Show image',
        ];

        yield 'value is a URL with http' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/page.html"/>',
            '<a href="http://example.org/page.html" title="Go to website" target="_blank" rel="noreferrer">stubbed icon</a> http://example.org/page.html',
            'goToWebsite',
            'Go to website',
        ];

        yield 'value is a URL with https' => [
            '<schema:adminPanel.propertyValue name="some-name" value="https://example.org/page.html"/>',
            '<a href="https://example.org/page.html" title="Go to website" target="_blank" rel="noreferrer">stubbed icon</a> https://example.org/page.html',
            'goToWebsite',
            'Go to website',
        ];
    }

    /**
     * @test
     */
    public function additionalManualsAreRenderedCorrectly(): void
    {
        $languageMap = [
            [Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.openDocumentationOnSchemaOrg', 'Open documentation on schema.org'],
            [Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.openGoogleReference', 'Open Google reference'],
            [Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.openYandexReference', 'Open Yandex reference'],
        ];

        $this->languageServiceStub
            ->method('sL')
            ->willReturnMap($languageMap);

        PropertyValueViewHelper::setAdditionalManuals([
            'Thing' => [
                [
                    'provider' => 'google',
                    'link' => 'https://example.org/Thing',
                ],
                [
                    'provider' => 'yandex',
                    'link' => 'https://example.com/Thing',
                ],
            ],
        ]);

        $actual = $this->renderTemplate(
            '<schema:adminPanel.propertyValue name="@type" value="Thing"/>'
        );

        self::assertSame(
            '<a href="https://schema.org/Thing" title="Open documentation on schema.org" target="_blank" rel="noreferrer">stubbed icon</a> <a href="https://example.org/Thing" title="Open Google reference" target="_blank" rel="noreferrer">stubbed icon</a> <a href="https://example.com/Thing" title="Open Yandex reference" target="_blank" rel="noreferrer">stubbed icon</a> Thing',
            $actual
        );
    }

    /**
     * @test
     */
    public function additionalManualsWithLikeReferenceAreRenderedCorrectly(): void
    {
        $languageMap = [
            [Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.openDocumentationOnSchemaOrg', 'Open documentation on schema.org'],
            [Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.openGoogleReference', 'Open Google reference'],
        ];

        $this->languageServiceStub
            ->method('sL')
            ->willReturnMap($languageMap);

        PropertyValueViewHelper::setAdditionalManuals([
            'Foo' => [
                'like' => 'Bar'
            ],
            'Bar' => [
                [
                    'provider' => 'google',
                    'link' => 'https://example.org/Bar',
                ],
            ],
        ]);

        $actual = $this->renderTemplate(
            '<schema:adminPanel.propertyValue name="@type" value="Foo"/>'
        );

        self::assertSame(
            '<a href="https://schema.org/Foo" title="Open documentation on schema.org" target="_blank" rel="noreferrer">stubbed icon</a> <a href="https://example.org/Bar" title="Open Google reference" target="_blank" rel="noreferrer">stubbed icon</a> Foo',
            $actual
        );
    }

    /**
     * @test
     */
    public function emptyProviderInAdditionalManualsDoesNotShowTheLink(): void
    {
        $this->languageServiceStub
            ->method('sL')
            ->with(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.openDocumentationOnSchemaOrg')
            ->willReturn('Open documentation on schema.org');

        PropertyValueViewHelper::setAdditionalManuals([
            'Thing' => [
                [
                    'link' => 'https://example.org/Thing',
                ],
            ],
        ]);

        $actual = $this->renderTemplate(
            '<schema:adminPanel.propertyValue name="@type" value="Thing"/>'
        );

        self::assertSame(
            '<a href="https://schema.org/Thing" title="Open documentation on schema.org" target="_blank" rel="noreferrer">stubbed icon</a> Thing',
            $actual
        );
    }

    /**
     * @test
     */
    public function unknownProviderInAdditionalManualsDoesNotShowTheLink(): void
    {
        $this->languageServiceStub
            ->method('sL')
            ->with(Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.openDocumentationOnSchemaOrg')
            ->willReturn('Open documentation on schema.org');

        PropertyValueViewHelper::setAdditionalManuals([
            'Thing' => [
                [
                    'provider' => 'unknown',
                    'link' => 'https://example.org/Thing',
                ],
            ],
        ]);

        $actual = $this->renderTemplate(
            '<schema:adminPanel.propertyValue name="@type" value="Thing"/>'
        );

        self::assertSame(
            '<a href="https://schema.org/Thing" title="Open documentation on schema.org" target="_blank" rel="noreferrer">stubbed icon</a> Thing',
            $actual
        );
    }
}
