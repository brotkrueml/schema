<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional\ViewHelpers;

use Brotkrueml\Schema\ViewHelpers\NodeIdentifierViewHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextFactory;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3Fluid\Fluid\View\TemplateView;

#[CoversClass(NodeIdentifierViewHelper::class)]
final class NodeIdentifierViewHelperTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'brotkrueml/schema',
    ];

    #[Test]
    public function viewHelperPrintsNodeIdentifiersCorrectly(): void
    {
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource(
            '<schema:nodeIdentifier id="some-id"/>',
        );

        self::assertSame('some-id', (new TemplateView($context))->render());
    }

    #[Test]
    public function useInlineNotationAndPassValueToVariable(): void
    {
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource('
<f:variable name="identifier1" value="{schema:nodeIdentifier(id: \'https://example.org/#john-smith\')}"/>
<f:variable name="identifier2" value="{schema:nodeIdentifier(id: \'https://example.org/#sarah-jane-smith\')}"/>
{identifier1} {identifier2}
        ');

        self::assertSame('https://example.org/#john-smith https://example.org/#sarah-jane-smith', \trim((string) (new TemplateView($context))->render()));
    }
}
