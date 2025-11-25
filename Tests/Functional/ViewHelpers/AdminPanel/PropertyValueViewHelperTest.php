<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional\ViewHelpers\AdminPanel;

use Brotkrueml\Schema\Manual\Publisher;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\Thing;
use Brotkrueml\Schema\Type\TypeRegistry;
use Brotkrueml\Schema\ViewHelpers\AdminPanel\PropertyValueViewHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextFactory;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3Fluid\Fluid\View\TemplateView;

#[CoversClass(PropertyValueViewHelper::class)]
final class PropertyValueViewHelperTest extends FunctionalTestCase
{
    /**
     * @var list<string>
     */
    protected array $testExtensionsToLoad = [
        'brotkrueml/schema',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->importCSVDataSet(__DIR__ . '/../../Fixtures/be_users.csv');
        $this->setUpBackendUser(1);
    }

    #[Test]
    #[DataProvider('dataProvider')]
    public function viewHelperReturnsOutputCorrectly(
        string $template,
        string $expected,
    ): void {
        $typo3Version = (new Typo3Version())->getMajorVersion();
        if ($typo3Version >= 14) {
            // @todo Find solution to test it
            self::markTestSkipped('Dynamic output with timestamp on assets');
        }

        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource($template);

        $actual = $this->trimLines((new TemplateView($context))->render());

        self::assertSame($expected, $actual);
    }

    /**
     * @return \Iterator<array<string, string>>
     */
    public static function dataProvider(): iterable
    {
        yield 'when value is an array, an empty string is returned' => [
            'template' => '<schema:adminPanel.propertyValue name="some-property" value="{0: \'some-value\'}"/>',
            'expected' => '',
        ];

        yield '@id value is returned unchanged' => [
            'template' => '<schema:adminPanel.propertyValue name="@id" value="some-id"/>',
            'expected' => 'some-id',
        ];

        yield '@id value is htmlspecialchar-d' => [
            'template' => '<schema:adminPanel.propertyValue name="@id" value="some&\"<id>"/>',
            'expected' => 'some&amp;&quot;&lt;id&gt;',
        ];

        yield '@type is linked to schema.org documentation' => [
            'template' => '<schema:adminPanel.propertyValue name="@type" value="Thing"/>',
            'expected' => <<<EXPECTED
<span class="ext-schema-adminpanel-property">Thing</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-ext-schema-documentation-schema" data-identifier="ext-schema-documentation-schema" aria-hidden="true">
<span class="icon-markup">
<img src="typo3conf/ext/schema/Resources/Public/Icons/documentation-schema.svg" width="16" height="16" alt="" />
</span>

</span> <a class="ext-schema-adminpanel-link" href="https://schema.org/Thing" target="_blank" rel="noreferrer">Schema.org</a></span></span>
EXPECTED,
        ];

        yield '@type value is htmlspecialchar-d' => [
            'template' => '<schema:adminPanel.propertyValue name="@type" value="Th&ing"/>',
            'expected' => <<<EXPECTED
<span class="ext-schema-adminpanel-property">Th&amp;ing</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-ext-schema-documentation-schema" data-identifier="ext-schema-documentation-schema" aria-hidden="true">
<span class="icon-markup">
<img src="typo3conf/ext/schema/Resources/Public/Icons/documentation-schema.svg" width="16" height="16" alt="" />
</span>

</span> <a class="ext-schema-adminpanel-link" href="https://schema.org/Th&amp;ing" target="_blank" rel="noreferrer">Schema.org</a></span></span>
EXPECTED,
        ];

        yield 'value is returned unchanged if not a URL' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="some-property"/>',
            'expected' => 'some-property',
        ];

        yield 'value id returned unchanged if not a http(s) URL' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="ftp://example.org/"/>',
            'expected' => 'ftp://example.org/',
        ];

        yield 'value is htmlspecialchar-d if not a URL' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="some <property>"/>',
            'expected' => 'some &lt;property&gt;',
        ];

        yield 'value is a schema.org URL with http' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="https://schema.org/Thing"/>',
            'expected' => <<<EXPECTED
<span class="ext-schema-adminpanel-property">https://schema.org/Thing</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-ext-schema-documentation-schema" data-identifier="ext-schema-documentation-schema" aria-hidden="true">
<span class="icon-markup">
<img src="typo3conf/ext/schema/Resources/Public/Icons/documentation-schema.svg" width="16" height="16" alt="" />
</span>

</span> <a class="ext-schema-adminpanel-link" href="https://schema.org/Thing" target="_blank" rel="noreferrer">Schema.org</a></span></span>
EXPECTED,
        ];

        yield 'value is a schema.org URL with https' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="https://schema.org/Thing"/>',
            'expected' => <<<EXPECTED
<span class="ext-schema-adminpanel-property">https://schema.org/Thing</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-ext-schema-documentation-schema" data-identifier="ext-schema-documentation-schema" aria-hidden="true">
<span class="icon-markup">
<img src="typo3conf/ext/schema/Resources/Public/Icons/documentation-schema.svg" width="16" height="16" alt="" />
</span>

</span> <a class="ext-schema-adminpanel-link" href="https://schema.org/Thing" target="_blank" rel="noreferrer">Schema.org</a></span></span>
EXPECTED,
        ];

        yield 'value is a gif image and returned with a link' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.gif"/>',
            'expected' => <<<EXPECTED
<span class="ext-schema-adminpanel-property">http://example.org/image.gif</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-actions-image" data-identifier="actions-image" aria-hidden="true">
<span class="icon-markup">
<svg class="icon-color"><use xlink:href="typo3/sysext/core/Resources/Public/Icons/T3Icons/sprites/actions.svg#actions-image" /></svg>
</span>

</span> <a class="ext-schema-adminpanel-link" href="http://example.org/image.gif" target="_blank" rel="noreferrer">Show image</a></span></span>
EXPECTED,
        ];

        yield 'value is a jpg image and returned with a link' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.jpg"/>',
            'expected' => <<<EXPECTED
<span class="ext-schema-adminpanel-property">http://example.org/image.jpg</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-actions-image" data-identifier="actions-image" aria-hidden="true">
<span class="icon-markup">
<svg class="icon-color"><use xlink:href="typo3/sysext/core/Resources/Public/Icons/T3Icons/sprites/actions.svg#actions-image" /></svg>
</span>

</span> <a class="ext-schema-adminpanel-link" href="http://example.org/image.jpg" target="_blank" rel="noreferrer">Show image</a></span></span>
EXPECTED,
        ];

        yield 'value is a jpeg image and returned with a link' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.jpeg"/>',
            'expected' => <<<EXPECTED
<span class="ext-schema-adminpanel-property">http://example.org/image.jpeg</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-actions-image" data-identifier="actions-image" aria-hidden="true">
<span class="icon-markup">
<svg class="icon-color"><use xlink:href="typo3/sysext/core/Resources/Public/Icons/T3Icons/sprites/actions.svg#actions-image" /></svg>
</span>

</span> <a class="ext-schema-adminpanel-link" href="http://example.org/image.jpeg" target="_blank" rel="noreferrer">Show image</a></span></span>
EXPECTED,
        ];

        yield 'value is a png image and returned with a link' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.png"/>',
            'expected' => <<<EXPECTED
<span class="ext-schema-adminpanel-property">http://example.org/image.png</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-actions-image" data-identifier="actions-image" aria-hidden="true">
<span class="icon-markup">
<svg class="icon-color"><use xlink:href="typo3/sysext/core/Resources/Public/Icons/T3Icons/sprites/actions.svg#actions-image" /></svg>
</span>

</span> <a class="ext-schema-adminpanel-link" href="http://example.org/image.png" target="_blank" rel="noreferrer">Show image</a></span></span>
EXPECTED,
        ];

        yield 'value is a svg image and returned with a link' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="https://example.org/image.svg"/>',
            'expected' => <<<EXPECTED
<span class="ext-schema-adminpanel-property">https://example.org/image.svg</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-actions-image" data-identifier="actions-image" aria-hidden="true">
<span class="icon-markup">
<svg class="icon-color"><use xlink:href="typo3/sysext/core/Resources/Public/Icons/T3Icons/sprites/actions.svg#actions-image" /></svg>
</span>

</span> <a class="ext-schema-adminpanel-link" href="https://example.org/image.svg" target="_blank" rel="noreferrer">Show image</a></span></span>
EXPECTED,
        ];

        yield 'value is a gif image with uppercase extension and returned with a link' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.GIF"/>',
            'expected' => <<<EXPECTED
<span class="ext-schema-adminpanel-property">http://example.org/image.GIF</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-actions-image" data-identifier="actions-image" aria-hidden="true">
<span class="icon-markup">
<svg class="icon-color"><use xlink:href="typo3/sysext/core/Resources/Public/Icons/T3Icons/sprites/actions.svg#actions-image" /></svg>
</span>

</span> <a class="ext-schema-adminpanel-link" href="http://example.org/image.GIF" target="_blank" rel="noreferrer">Show image</a></span></span>
EXPECTED,
        ];

        yield 'value is a jpg image with uppercase extension and returned with a link' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.JPG"/>',
            'expected' => <<<EXPECTED
<span class="ext-schema-adminpanel-property">http://example.org/image.JPG</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-actions-image" data-identifier="actions-image" aria-hidden="true">
<span class="icon-markup">
<svg class="icon-color"><use xlink:href="typo3/sysext/core/Resources/Public/Icons/T3Icons/sprites/actions.svg#actions-image" /></svg>
</span>

</span> <a class="ext-schema-adminpanel-link" href="http://example.org/image.JPG" target="_blank" rel="noreferrer">Show image</a></span></span>
EXPECTED,
        ];

        yield 'value is a jpeg image with uppercase extension and returned with a link' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.JPEG"/>',
            'expected' => <<<EXPECTED
<span class="ext-schema-adminpanel-property">http://example.org/image.JPEG</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-actions-image" data-identifier="actions-image" aria-hidden="true">
<span class="icon-markup">
<svg class="icon-color"><use xlink:href="typo3/sysext/core/Resources/Public/Icons/T3Icons/sprites/actions.svg#actions-image" /></svg>
</span>

</span> <a class="ext-schema-adminpanel-link" href="http://example.org/image.JPEG" target="_blank" rel="noreferrer">Show image</a></span></span>
EXPECTED,
        ];

        yield 'value is a png image with uppercase extension and returned with a link' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/image.PNG"/>',
            'expected' => <<<EXPECTED
<span class="ext-schema-adminpanel-property">http://example.org/image.PNG</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-actions-image" data-identifier="actions-image" aria-hidden="true">
<span class="icon-markup">
<svg class="icon-color"><use xlink:href="typo3/sysext/core/Resources/Public/Icons/T3Icons/sprites/actions.svg#actions-image" /></svg>
</span>

</span> <a class="ext-schema-adminpanel-link" href="http://example.org/image.PNG" target="_blank" rel="noreferrer">Show image</a></span></span>
EXPECTED,
        ];

        yield 'value is a svg image with uppercase extension and returned with a link' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="https://example.org/image.SVG"/>',
            'expected' => <<<EXPECTED
<span class="ext-schema-adminpanel-property">https://example.org/image.SVG</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-actions-image" data-identifier="actions-image" aria-hidden="true">
<span class="icon-markup">
<svg class="icon-color"><use xlink:href="typo3/sysext/core/Resources/Public/Icons/T3Icons/sprites/actions.svg#actions-image" /></svg>
</span>

</span> <a class="ext-schema-adminpanel-link" href="https://example.org/image.SVG" target="_blank" rel="noreferrer">Show image</a></span></span>
EXPECTED,
        ];

        yield 'value is a URL with http' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="http://example.org/page.html"/>',
            'expected' => <<<EXPECTED
<span class="ext-schema-adminpanel-property">http://example.org/page.html</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-actions-link" data-identifier="actions-link" aria-hidden="true">
<span class="icon-markup">
<svg class="icon-color"><use xlink:href="typo3/sysext/core/Resources/Public/Icons/T3Icons/sprites/actions.svg#actions-link" /></svg>
</span>

</span> <a class="ext-schema-adminpanel-link" href="http://example.org/page.html" target="_blank" rel="noreferrer">Go to website</a></span></span>
EXPECTED,
        ];

        yield 'value is a URL with https' => [
            'template' => '<schema:adminPanel.propertyValue name="some-name" value="https://example.org/page.html"/>',
            'expected' => <<<EXPECTED
<span class="ext-schema-adminpanel-property">https://example.org/page.html</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-actions-link" data-identifier="actions-link" aria-hidden="true">
<span class="icon-markup">
<svg class="icon-color"><use xlink:href="typo3/sysext/core/Resources/Public/Icons/T3Icons/sprites/actions.svg#actions-link" /></svg>
</span>

</span> <a class="ext-schema-adminpanel-link" href="https://example.org/page.html" target="_blank" rel="noreferrer">Go to website</a></span></span>
EXPECTED,
        ];
    }

    #[Test]
    public function additionalManualsAreRenderedCorrectly(): void
    {
        $typo3Version = (new Typo3Version())->getMajorVersion();
        if ($typo3Version >= 14) {
            // @todo Find solution to test it
            self::markTestSkipped('Dynamic output with timestamp on assets');
        }

        $typeRegistry = $this->get(TypeRegistry::class);
        $typeRegistry->addType('Thing', Thing::class);
        $typeRegistry->addManualForType('Thing', [Publisher::Google, 'Some link', 'https://example.org/Thing']);
        $typeRegistry->addManualForType('Thing', [Publisher::Yandex, 'Another link', 'https://example.com/Thing']);

        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource(
            '<schema:adminPanel.propertyValue name="@type" value="Thing"/>',
        );

        $actual = $this->trimLines((new TemplateView($context))->render());

        $expected = <<< EXPECTED
<span class="ext-schema-adminpanel-property">Thing</span> <span class="ext-schema-adminpanel-links"><span><span class="t3js-icon icon icon-size-small icon-state-default icon-ext-schema-documentation-schema" data-identifier="ext-schema-documentation-schema" aria-hidden="true">
<span class="icon-markup">
<img src="typo3conf/ext/schema/Resources/Public/Icons/documentation-schema.svg" width="16" height="16" alt="" />
</span>

</span> <a class="ext-schema-adminpanel-link" href="https://schema.org/Thing" target="_blank" rel="noreferrer">Schema.org</a></span> <span><span title="Google" class="t3js-icon icon icon-size-small icon-state-default icon-ext-schema-documentation-google" data-identifier="ext-schema-documentation-google" aria-hidden="true">
<span class="icon-markup">
<img src="typo3conf/ext/schema/Resources/Public/Icons/documentation-google.svg" width="16" height="16" alt="" />
</span>

</span> <a class="ext-schema-adminpanel-link" href="https://example.org/Thing" target="_blank" rel="noreferrer">Some link</a></span> <span><span title="Yandex" class="t3js-icon icon icon-size-small icon-state-default icon-ext-schema-documentation-yandex" data-identifier="ext-schema-documentation-yandex" aria-hidden="true">
<span class="icon-markup">
<img src="typo3conf/ext/schema/Resources/Public/Icons/documentation-yandex.svg" width="16" height="16" alt="" />
</span>

</span> <a class="ext-schema-adminpanel-link" href="https://example.com/Thing" target="_blank" rel="noreferrer">Another link</a></span></span>
EXPECTED;

        self::assertSame($expected, $actual);
    }

    private function trimLines(string $lines): string
    {
        return \implode("\n", \array_map(trim(...), \explode("\n", $lines)));
    }
}
