<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\EventListener;

use Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent;
use Brotkrueml\Schema\Model\Type;

/**
 * The following properties has be available as official
 * but were moved because of reasons to pending again.
 * These properties are registered again to avoid
 * breaking changes.
 */
class RegisterTypePropertiesMovedFromOfficialToPending
{
    private $ineligibleRegionTypes = [
        Type\ActionAccessSpecification::class,
        Type\AggregateOffer::class,
        Type\DeliveryChargeSpecification::class,
        Type\Demand::class,
        Type\Offer::class,
    ];

    private $sportTypes = [
        Type\SportsEvent::class,
        Type\SportsOrganization::class,
        Type\SportsTeam::class,
    ];

    private $subtitleLanguageTypes = [
        Type\BroadcastEvent::class,
        Type\Movie::class,
        Type\ScreeningEvent::class,
        Type\TVEpisode::class,
    ];

    public function __invoke(RegisterAdditionalTypePropertiesEvent $event): void
    {
        $type = $event->getType();

        if ($type === Type\Person::class) {
            $event->registerAdditionalProperty('gender');

            /* from official to pending in schema version 3.7 */
            $event->registerAdditionalProperty('jobTitle');
        }

        if (\in_array($type, $this->ineligibleRegionTypes)) {
            /* from official to pending in schema version 4.0 */
            $event->registerAdditionalProperty('ineligibleRegion');
        }

        if (\in_array($type, $this->sportTypes)) {
            /* from official to pending in schema version 5.0 */
            $event->registerAdditionalProperty('sport');
        }

        if (\in_array($type, $this->subtitleLanguageTypes)) {
            /* from official to pending in schema version 4.0 */
            $event->registerAdditionalProperty('subtitleLanguage');
        }
    }
}
