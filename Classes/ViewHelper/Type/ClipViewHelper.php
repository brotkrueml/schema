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
 * A short TV or radio program or a segment/part of a program.
 *
 * schema.org version 3.6
 */
class ClipViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('actor', 'mixed', 'An actor, e.g. in tv, radio, movie, video games etc., or in an event. Actors can be associated with individual items or with a series, episode, clip.');
        $this->registerArgument('clipNumber', 'mixed', 'Position of the clip within an ordered group of clips.');
        $this->registerArgument('director', 'mixed', 'A director of e.g. tv, radio, movie, video gaming etc. content, or of an event. Directors can be associated with individual items or with a series, episode, clip.');
        $this->registerArgument('musicBy', 'mixed', 'The composer of the soundtrack.');
        $this->registerArgument('partOfEpisode', 'mixed', 'The episode to which this clip belongs.');
        $this->registerArgument('partOfSeason', 'mixed', 'The season to which this episode belongs.');
        $this->registerArgument('partOfSeries', 'mixed', 'The series to which this episode or season belongs.');
    }
}
