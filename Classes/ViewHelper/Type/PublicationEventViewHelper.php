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
 * A PublicationEvent corresponds indifferently to the event of publication for a CreativeWork of any type e.g. a broadcast event, an on-demand event, a book/journal publication via a variety of delivery media.
 *
 * schema.org version 3.6
 */
class PublicationEventViewHelper extends EventViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('publishedOn', 'mixed', 'A broadcast service associated with the publication event.');
    }
}
