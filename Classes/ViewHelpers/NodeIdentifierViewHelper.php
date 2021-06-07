<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\ViewHelpers;

use Brotkrueml\Schema\Core\Model\NodeIdentifier;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ViewHelper for creating a NodeIdentifier.
 *
 * = Examples =
 * <code title="Using the view helper directly">
 * <schema:type.person name="John Smith" -id="{schema:nodeIdentifier(id: 'https://example.org/#john-smith')}"/>
 * </code>
 * <code title="Using the view helper via variable">
 * <f:variable name="identifier1" value="{schema:nodeIdentifier(id: 'https://example.org/#john-smith')}"/>
 * <f:variable name="identifier2" value="{schema:nodeIdentifier(id: 'https://example.org/#sarah-jane-smith')}"/>
 * <schema:type.person name="John Smith" -id="{identifier1}" knows="{identifier2}"/>
 * <schema:type.person name="Sarah Jane Smith" -id="{identifier2}" knows="{identifier1}"/>
 * </code>
 */
final class NodeIdentifierViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('id', 'string', 'The identifier for the node', true);
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): NodeIdentifier {
        return new NodeIdentifier($arguments['id']);
    }
}
