<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\EventListener;

use Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent;
use Brotkrueml\Schema\EventListener\RegisterTypePropertiesMovedFromOfficialToPending;
use Brotkrueml\Schema\Model\Type;
use PHPUnit\Framework\TestCase;

class RegisterTypePropertiesMovedFromOfficialToPendingTest extends TestCase
{
    /**
     * @var RegisterTypePropertiesMovedFromOfficialToPending
     */
    private $subject;

    protected function setUp(): void
    {
        $this->subject = new RegisterTypePropertiesMovedFromOfficialToPending();
    }

    /**
     * @test
     */
    public function additionalPropertiesForPersonTypeAreRegistered(): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent(Type\Person::class);
        ($this->subject)($event);

        self::assertContains('gender', $event->getAdditionalProperties());
        self::assertContains('jobTitle', $event->getAdditionalProperties());
    }

    /**
     * @test
     * @dataProvider dataProviderForHasEnergyConsumptionDetails
     */
    public function additionalPropertyHasEnergyConsumptionDetailsIsRegisteredCorrectly(string $type): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent($type);
        ($this->subject)($event);

        self::assertContains('hasEnergyConsumptionDetails', $event->getAdditionalProperties());
    }

    public function dataProviderForHasEnergyConsumptionDetails(): array
    {
        return [
            [Type\Car::class],
            [Type\IndividualProduct::class],
            [Type\Product::class],
            [Type\ProductModel::class],
            [Type\SomeProducts::class],
            [Type\Vehicle::class],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderForIneligibleRegion
     */
    public function additionalPropertyIneligibleRegionIsRegisteredCorrectly(string $type): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent($type);
        ($this->subject)($event);

        self::assertContains('ineligibleRegion', $event->getAdditionalProperties());
    }

    public function dataProviderForIneligibleRegion(): array
    {
        return [
            [Type\ActionAccessSpecification::class],
            [Type\AggregateOffer::class],
            [Type\DeliveryChargeSpecification::class],
            [Type\Demand::class],
            [Type\Offer::class],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderForSport
     */
    public function additionalPropertySportIsRegisteredCorrectly(string $type): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent($type);
        ($this->subject)($event);

        self::assertContains('sport', $event->getAdditionalProperties());
    }

    public function dataProviderForSport(): array
    {
        return [
            [Type\SportsEvent::class],
            [Type\SportsOrganization::class],
            [Type\SportsTeam::class],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderForSubtitleLanguage
     */
    public function additionalPropertySubtitleLanguageIsRegisteredCorrectly(string $type): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent($type);
        ($this->subject)($event);

        self::assertContains('subtitleLanguage', $event->getAdditionalProperties());
    }

    public function dataProviderForSubtitleLanguage(): array
    {
        return [
            [Type\BroadcastEvent::class],
            [Type\Movie::class],
            [Type\ScreeningEvent::class],
            [Type\TVEpisode::class],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderForOccupationalCategory
     */
    public function additionalPropertyOccupationalCategorIsRegisteredCorrectly(string $type): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent($type);
        ($this->subject)($event);

        self::assertContains('occupationalCategory', $event->getAdditionalProperties());
    }

    public function dataProviderForOccupationalCategory(): array
    {
        return [
            [Type\JobPosting::class],
            [Type\Occupation::class],
        ];
    }
}
