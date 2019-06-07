<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A summary of how users have interacted with this CreativeWork. In most cases, authors will use a subtype to specify the specific type of interaction.
 *
 * schema.org version 3.6
 */
class InteractionCounterViewHelper extends StructuredValueViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('interactionService', 'mixed', 'The WebSite or SoftwareApplication where the interactions took place.');
        $this->registerArgument('interactionType', 'mixed', 'The Action representing the type of interaction. For up votes, +1s, etc. use LikeAction. For down votes use DislikeAction. Otherwise, use the most specific Action.');
        $this->registerArgument('userInteractionCount', 'mixed', 'The number of interactions for the CreativeWork using the WebSite or SoftwareApplication.');
    }
}
