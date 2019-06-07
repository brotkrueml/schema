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
 * A musical group, such as a band, an orchestra, or a choir. Can also be a solo musician.
 *
 * schema.org version 3.6
 */
class MusicGroupViewHelper extends PerformingGroupViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('album', 'mixed', 'A music album.');
        $this->registerArgument('genre', 'mixed', 'Genre of the creative work, broadcast channel or group.');
        $this->registerArgument('track', 'mixed', 'A music recording (track)&#x2014;usually a single song. If an ItemList is given, the list should contain items of type MusicRecording.');
    }
}
