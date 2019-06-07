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
 * A musical composition.
 *
 * schema.org version 3.6
 */
class MusicCompositionViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('composer', 'mixed', 'The person or organization who wrote a composition, or who is the composer of a work performed at some event.');
        $this->registerArgument('firstPerformance', 'mixed', 'The date and place the work was first performed.');
        $this->registerArgument('includedComposition', 'mixed', 'Smaller compositions included in this work (e.g. a movement in a symphony).');
        $this->registerArgument('iswcCode', 'mixed', 'The International Standard Musical Work Code for the composition.');
        $this->registerArgument('lyricist', 'mixed', 'The person who wrote the words.');
        $this->registerArgument('lyrics', 'mixed', 'The words in the song.');
        $this->registerArgument('musicArrangement', 'mixed', 'An arrangement derived from the composition.');
        $this->registerArgument('musicCompositionForm', 'mixed', 'The type of composition (e.g. overture, sonata, symphony, etc.).');
        $this->registerArgument('musicalKey', 'mixed', 'The key, mode, or scale this composition uses.');
        $this->registerArgument('recordedAs', 'mixed', 'An audio recording of the work.');
    }
}
