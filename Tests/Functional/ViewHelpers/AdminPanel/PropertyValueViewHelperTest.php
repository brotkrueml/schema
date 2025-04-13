<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional\ViewHelpers\AdminPanel;

use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Manual\Publisher;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\Thing;
use Brotkrueml\Schema\Tests\Functional\ViewHelpers\ViewHelperTestCase;
use Brotkrueml\Schema\Type\TypeProvider;
use Brotkrueml\Schema\ViewHelpers\AdminPanel\PropertyValueViewHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Stub;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

#[CoversClass(PropertyValueViewHelper::class)]
final class PropertyValueViewHelperTest extends ViewHelperTestCase
{
    /**
     * @var Stub|LanguageService
     */
    protected $languageServiceStub;

    protected function setUp(): void
    {
        parent::setUp();

        $this->languageServiceStub = self::createStub(LanguageService::class);
        $GLOBALS['LANG'] = $this->languageServiceStub;

        $iconStub = self::createStub(Icon::class);
        if (\method_exists(Icon::class, 'setTitle')) {
            // @todo remove method check once compatibility with TYPO3 v11 is dropped, setTitle() is available since TYPO3 v12
            $iconStub
                ->method('setTitle')
                ->willReturn($iconStub);
        }
        $iconStub
            ->method('render')
            ->willReturn('stubbed icon');
        $iconFactoryStub = self::createStub(IconFactory::class);
        $iconFactoryStub
            ->method('getIcon')
            ->willReturn($iconStub);
        GeneralUtility::addInstance(IconFactory::class, $iconFactoryStub);
    }

    protected function tearDown(): void
    {
        unset($GLOBALS['LANG']);
        GeneralUtility::purgeInstances();
        parent::tearDown();
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function viewHelperReturnsOutputCorrectly(
        string $template,
        string $expected,
        string $localisedInput = '',
        string $localisedOutput = '',
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

    public static function dataProvider(): \Iterator
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
            '<span class="ext-schema-adminpanel-property">Thing</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="https://schema.org/Thing" target="_blank" rel="noreferrer">Schema.org</a></span></span>',
        ];

        yield '@type value is htmlspecialchar\'d' => [
            '<schema:adminPanel.propertyValue name="@type" value="Th&ing"/>',
            '<span class="ext-schema-adminpanel-property">Th&amp;ing</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="https://schema.org/Th&amp;ing" target="_blank" rel="noreferrer">Schema.org</a></span></span>',
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
            '<span class="ext-schema-adminpanel-property">https://schema.org/Thing</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="https://schema.org/Thing" target="_blank" rel="noreferrer">Schema.org</a></span></span>',
        ];

        yield 'value is a schema.org URL with https' => [
            '<schema:adminPanel.propertyValue name="some-name" value="https://schema.org/Thing"/>',
            '<span class="ext-schema-adminpanel-property">https://schema.org/Thing</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="https://schema.org/Thing" target="_blank" rel="noreferrer">Schema.org</a></span></span>',
        ];

        yield 'value is a gif image and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.gif"/>',
            '<span class="ext-schema-adminpanel-property">http://example.org/image.gif</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="http://example.org/image.gif" target="_blank" rel="noreferrer">Show image</a></span></span>',
            'showImage',
            'Show image',
        ];

        yield 'value is a jpg image and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.jpg"/>',
            '<span class="ext-schema-adminpanel-property">http://example.org/image.jpg</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="http://example.org/image.jpg" target="_blank" rel="noreferrer">Show image</a></span></span>',
            'showImage',
            'Show image',
        ];

        yield 'value is a jpeg image and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.jpeg"/>',
            '<span class="ext-schema-adminpanel-property">http://example.org/image.jpeg</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="http://example.org/image.jpeg" target="_blank" rel="noreferrer">Show image</a></span></span>',
            'showImage',
            'Show image',
        ];

        yield 'value is a png image and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.png"/>',
            '<span class="ext-schema-adminpanel-property">http://example.org/image.png</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="http://example.org/image.png" target="_blank" rel="noreferrer">Show image</a></span></span>',
            'showImage',
            'Show image',
        ];

        yield 'value is a svg image and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="https://example.org/image.svg"/>',
            '<span class="ext-schema-adminpanel-property">https://example.org/image.svg</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="https://example.org/image.svg" target="_blank" rel="noreferrer">Show image</a></span></span>',
            'showImage',
            'Show image',
        ];

        yield 'value is a gif image with uppercase extension and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.GIF"/>',
            '<span class="ext-schema-adminpanel-property">http://example.org/image.GIF</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="http://example.org/image.GIF" target="_blank" rel="noreferrer">Show image</a></span></span>',
            'showImage',
            'Show image',
        ];

        yield 'value is a jpg image with uppercase extension and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.JPG"/>',
            '<span class="ext-schema-adminpanel-property">http://example.org/image.JPG</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="http://example.org/image.JPG" target="_blank" rel="noreferrer">Show image</a></span></span>',
            'showImage',
            'Show image',
        ];

        yield 'value is a jpeg image with uppercase extension and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.JPEG"/>',
            '<span class="ext-schema-adminpanel-property">http://example.org/image.JPEG</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="http://example.org/image.JPEG" target="_blank" rel="noreferrer">Show image</a></span></span>',
            'showImage',
            'Show image',
        ];

        yield 'value is a png image with uppercase extension and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.PNG"/>',
            '<span class="ext-schema-adminpanel-property">http://example.org/image.PNG</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="http://example.org/image.PNG" target="_blank" rel="noreferrer">Show image</a></span></span>',
            'showImage',
            'Show image',
        ];

        yield 'value is a svg image with uppercase extension and returned with a link' => [
            '<schema:adminPanel.propertyValue name="some-name" value="https://example.org/image.SVG"/>',
            '<span class="ext-schema-adminpanel-property">https://example.org/image.SVG</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="https://example.org/image.SVG" target="_blank" rel="noreferrer">Show image</a></span></span>',
            'showImage',
            'Show image',
        ];

        yield 'value is a URL with http' => [
            '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/page.html"/>',
            '<span class="ext-schema-adminpanel-property">http://example.org/page.html</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="http://example.org/page.html" target="_blank" rel="noreferrer">Go to website</a></span></span>',
            'goToWebsite',
            'Go to website',
        ];

        yield 'value is a URL with https' => [
            '<schema:adminPanel.propertyValue name="some-name" value="https://example.org/page.html"/>',
            '<span class="ext-schema-adminpanel-property">https://example.org/page.html</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="https://example.org/page.html" target="_blank" rel="noreferrer">Go to website</a></span></span>',
            'goToWebsite',
            'Go to website',
        ];
    }

    #[Test]
    public function additionalManualsAreRenderedCorrectly(): void
    {
        $typeProvider = new TypeProvider();
        $typeProvider->addType('Thing', Thing::class);
        $typeProvider->addManualForType('Thing', [Publisher::Google, 'Some link', 'https://example.org/Thing']);
        $typeProvider->addManualForType('Thing', [Publisher::Yandex, 'Another link', 'https://example.com/Thing']);
        GeneralUtility::setSingletonInstance(TypeProvider::class, $typeProvider);

        $actual = $this->renderTemplate(
            '<schema:adminPanel.propertyValue name="@type" value="Thing"/>',
        );

        self::assertSame(
            '<span class="ext-schema-adminpanel-property">Thing</span> <span class="ext-schema-adminpanel-links"><span>stubbed icon <a class="ext-schema-adminpanel-link" href="https://schema.org/Thing" target="_blank" rel="noreferrer">Schema.org</a></span> <span>stubbed icon <a class="ext-schema-adminpanel-link" href="https://example.org/Thing" target="_blank" rel="noreferrer">Some link</a></span> <span>stubbed icon <a class="ext-schema-adminpanel-link" href="https://example.com/Thing" target="_blank" rel="noreferrer">Another link</a></span></span>',
            $actual,
        );
    }
}
