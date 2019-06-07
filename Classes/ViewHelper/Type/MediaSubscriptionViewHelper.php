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
 * A subscription which allows a user to access media including audio, video, books, etc.
 *
 * schema.org version 3.6
 */
class MediaSubscriptionViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('authenticator', 'mixed', 'The Organization responsible for authenticating the user\'s subscription. For example, many media apps require a cable/satellite provider to authenticate your subscription before playing media.');
        $this->registerArgument('expectsAcceptanceOf', 'mixed', 'An Offer which must be accepted before the user can perform the Action. For example, the user may need to buy a movie before being able to watch it.');
    }
}
