<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

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
class InteractionCounter extends StructuredValue
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('interactionService', 'interactionType', 'userInteractionCount');
    }
}
