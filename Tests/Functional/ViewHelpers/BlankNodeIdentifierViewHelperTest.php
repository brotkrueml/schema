<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional\ViewHelpers;

use Brotkrueml\Schema\ViewHelpers\BlankNodeIdentifierViewHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextFactory;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3Fluid\Fluid\View\TemplateView;

#[CoversClass(BlankNodeIdentifierViewHelper::class)]
#[RunTestsInSeparateProcesses]
final class BlankNodeIdentifierViewHelperTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'brotkrueml/schema',
    ];

    #[Test]
    public function viewHelperUsedOncePrintsBlankNodeIdentifierCorrectly(): void
    {
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource(
            '<schema:blankNodeIdentifier/>',
        );

        self::assertSame('_:b0', (new TemplateView($context))->render());
    }

    #[Test]
    public function viewHelperUsedTwicePrintsBlankNodeIdentifiersCorrectly(): void
    {
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource(
            '<schema:blankNodeIdentifier/> <schema:blankNodeIdentifier/> <schema:blankNodeIdentifier/>',
        );

        self::assertSame('_:b0 _:b1 _:b2', (new TemplateView($context))->render());
    }

    #[Test]
    public function useInlineNotationAndPassValueToVariable(): void
    {
        $context = $this->get(RenderingContextFactory::class)->create();
        $context->getTemplatePaths()->setTemplateSource('
            <f:variable name="blankIdentifier1" value="{schema:blankNodeIdentifier()}"/>
            <f:variable name="blankIdentifier2" value="{schema:blankNodeIdentifier()}"/>
            {blankIdentifier1} {blankIdentifier2}
        ');

        self::assertSame('_:b0 _:b1', \trim((string) (new TemplateView($context))->render()));
    }
}
