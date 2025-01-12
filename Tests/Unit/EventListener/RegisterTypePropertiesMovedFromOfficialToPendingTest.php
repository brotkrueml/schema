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
use Brotkrueml\Schema\Model\Type\AboutPage;
use Brotkrueml\Schema\Model\Type\ActionAccessSpecification;
use Brotkrueml\Schema\Model\Type\AggregateOffer;
use Brotkrueml\Schema\Model\Type\BroadcastEvent;
use Brotkrueml\Schema\Model\Type\Car;
use Brotkrueml\Schema\Model\Type\DeliveryChargeSpecification;
use Brotkrueml\Schema\Model\Type\Demand;
use Brotkrueml\Schema\Model\Type\IndividualProduct;
use Brotkrueml\Schema\Model\Type\JobPosting;
use Brotkrueml\Schema\Model\Type\Movie;
use Brotkrueml\Schema\Model\Type\Occupation;
use Brotkrueml\Schema\Model\Type\Offer;
use Brotkrueml\Schema\Model\Type\Person;
use Brotkrueml\Schema\Model\Type\Product;
use Brotkrueml\Schema\Model\Type\ProductModel;
use Brotkrueml\Schema\Model\Type\ScreeningEvent;
use Brotkrueml\Schema\Model\Type\SomeProducts;
use Brotkrueml\Schema\Model\Type\SportsEvent;
use Brotkrueml\Schema\Model\Type\SportsOrganization;
use Brotkrueml\Schema\Model\Type\SportsTeam;
use Brotkrueml\Schema\Model\Type\TVEpisode;
use Brotkrueml\Schema\Model\Type\Vehicle;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(RegisterTypePropertiesMovedFromOfficialToPending::class)]
final class RegisterTypePropertiesMovedFromOfficialToPendingTest extends TestCase
{
    private RegisterTypePropertiesMovedFromOfficialToPending $subject;

    protected function setUp(): void
    {
        $this->subject = new RegisterTypePropertiesMovedFromOfficialToPending();
    }

    #[Test]
    public function additionalPropertiesForPersonTypeAreRegistered(): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent(Person::class);
        ($this->subject)($event);

        self::assertContains('gender', $event->getAdditionalProperties());
        self::assertContains('jobTitle', $event->getAdditionalProperties());
    }

    #[Test]
    #[DataProvider('dataProviderForHasEnergyConsumptionDetails')]
    public function additionalPropertyHasEnergyConsumptionDetailsIsRegisteredCorrectly(string $type): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent($type);
        ($this->subject)($event);

        self::assertContains('hasEnergyConsumptionDetails', $event->getAdditionalProperties());
    }

    public static function dataProviderForHasEnergyConsumptionDetails(): \Iterator
    {
        yield [Car::class];
        yield [IndividualProduct::class];
        yield [Product::class];
        yield [ProductModel::class];
        yield [SomeProducts::class];
        yield [Vehicle::class];
    }

    #[Test]
    #[DataProvider('dataProviderForIneligibleRegion')]
    public function additionalPropertyIneligibleRegionIsRegisteredCorrectly(string $type): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent($type);
        ($this->subject)($event);

        self::assertContains('ineligibleRegion', $event->getAdditionalProperties());
    }

    public static function dataProviderForIneligibleRegion(): \Iterator
    {
        yield [ActionAccessSpecification::class];
        yield [AggregateOffer::class];
        yield [DeliveryChargeSpecification::class];
        yield [Demand::class];
        yield [Offer::class];
    }

    /**
     * We test here only one type from the amount of types, just to verify that the
     * property is added correctly
     */
    #[Test]
    public function additionalPropertyProviderIsRegisteredCorrectly(): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent(AboutPage::class);
        ($this->subject)($event);

        self::assertContains('provider', $event->getAdditionalProperties());
    }

    #[Test]
    #[DataProvider('dataProviderForSport')]
    public function additionalPropertySportIsRegisteredCorrectly(string $type): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent($type);
        ($this->subject)($event);

        self::assertContains('sport', $event->getAdditionalProperties());
    }

    public static function dataProviderForSport(): \Iterator
    {
        yield [SportsEvent::class];
        yield [SportsOrganization::class];
        yield [SportsTeam::class];
    }

    #[Test]
    #[DataProvider('dataProviderForSubtitleLanguage')]
    public function additionalPropertySubtitleLanguageIsRegisteredCorrectly(string $type): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent($type);
        ($this->subject)($event);

        self::assertContains('subtitleLanguage', $event->getAdditionalProperties());
    }

    public static function dataProviderForSubtitleLanguage(): \Iterator
    {
        yield [BroadcastEvent::class];
        yield [Movie::class];
        yield [ScreeningEvent::class];
        yield [TVEpisode::class];
    }

    #[Test]
    #[DataProvider('dataProviderForOccupationalCategory')]
    public function additionalPropertyOccupationalCategorIsRegisteredCorrectly(string $type): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent($type);
        ($this->subject)($event);

        self::assertContains('occupationalCategory', $event->getAdditionalProperties());
    }

    public static function dataProviderForOccupationalCategory(): \Iterator
    {
        yield [JobPosting::class];
        yield [Occupation::class];
    }
}
