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
 * An action performed by a direct agent and indirect participants upon a direct object. Optionally happens at a location with the help of an inanimate instrument. The execution of the action may produce a result. Specific action sub-type documentation specifies the exact expectation of each argument/role.
 *
 * schema.org version 3.6
 */
class ActionViewHelper extends ThingViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('actionStatus', 'mixed', 'Indicates the current disposition of the Action.');
        $this->registerArgument('agent', 'mixed', 'The direct performer or driver of the action (animate or inanimate). e.g. John wrote a book.');
        $this->registerArgument('endTime', 'mixed', 'The endTime of something. For a reserved event or service (e.g. FoodEstablishmentReservation), the time that it is expected to end. For actions that span a period of time, when the action was performed. e.g. John wrote a book from January to December. For media, including audio and video, it\'s the time offset of the end of a clip within a larger file.');
        $this->registerArgument('error', 'mixed', 'For failed actions, more information on the cause of the failure.');
        $this->registerArgument('instrument', 'mixed', 'The object that helped the agent perform the action. e.g. John wrote a book with a pen.');
        $this->registerArgument('location', 'mixed', 'The location of for example where the event is happening, an organization is located, or where an action takes place.');
        $this->registerArgument('object', 'mixed', 'The object upon which the action is carried out, whose state is kept intact or changed. Also known as the semantic roles patient, affected or undergoer (which change their state) or theme (which doesn\'t). e.g. John read a book.');
        $this->registerArgument('participant', 'mixed', 'Other co-agents that participated in the action indirectly. e.g. John wrote a book with Steve.');
        $this->registerArgument('result', 'mixed', 'The result produced in the action. e.g. John wrote a book.');
        $this->registerArgument('startTime', 'mixed', 'The startTime of something. For a reserved event or service (e.g. FoodEstablishmentReservation), the time that it is expected to start. For actions that span a period of time, when the action was performed. e.g. John wrote a book from January to December. For media, including audio and video, it\'s the time offset of the start of a clip within a larger file.');
        $this->registerArgument('target', 'mixed', 'Indicates a target EntryPoint for an Action.');
    }
}
