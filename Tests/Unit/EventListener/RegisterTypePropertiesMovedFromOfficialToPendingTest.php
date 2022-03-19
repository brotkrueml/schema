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
    private RegisterTypePropertiesMovedFromOfficialToPending $subject;

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

    public function dataProviderForHasEnergyConsumptionDetails(): \Iterator
    {
        yield [Type\Car::class];
        yield [Type\IndividualProduct::class];
        yield [Type\Product::class];
        yield [Type\ProductModel::class];
        yield [Type\SomeProducts::class];
        yield [Type\Vehicle::class];
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

    public function dataProviderForIneligibleRegion(): \Iterator
    {
        yield [Type\ActionAccessSpecification::class];
        yield [Type\AggregateOffer::class];
        yield [Type\DeliveryChargeSpecification::class];
        yield [Type\Demand::class];
        yield [Type\Offer::class];
    }

    /**
     * We test here only one type from the amount of types, just to verify that the
     * property is added correctly
     * @test
     */
    public function additionalPropertyProviderIsRegisteredCorrectly(): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent(Type\AboutPage::class);
        ($this->subject)($event);

        self::assertContains('provider', $event->getAdditionalProperties());
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

    public function dataProviderForSport(): \Iterator
    {
        yield [Type\SportsEvent::class];
        yield [Type\SportsOrganization::class];
        yield [Type\SportsTeam::class];
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

    public function dataProviderForSubtitleLanguage(): \Iterator
    {
        yield [Type\BroadcastEvent::class];
        yield [Type\Movie::class];
        yield [Type\ScreeningEvent::class];
        yield [Type\TVEpisode::class];
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

    public function dataProviderForOccupationalCategory(): \Iterator
    {
        yield [Type\JobPosting::class];
        yield [Type\Occupation::class];
    }
}
