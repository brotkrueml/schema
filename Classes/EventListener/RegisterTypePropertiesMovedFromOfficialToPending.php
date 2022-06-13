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
    /** @var array<class-string> */
    private $hasEnergyConsumptionDetails = [
        Type\Car::class,
        Type\IndividualProduct::class,
        Type\Product::class,
        Type\ProductModel::class,
        Type\SomeProducts::class,
        Type\Vehicle::class,
    ];

    /** @var array<class-string> */
    private $ineligibleRegionTypes = [
        Type\ActionAccessSpecification::class,
        Type\AggregateOffer::class,
        Type\DeliveryChargeSpecification::class,
        Type\Demand::class,
        Type\Offer::class,
    ];

    /** @var array<class-string> */
    private $occupationalCategoryTypes = [
        Type\JobPosting::class,
        Type\Occupation::class,
    ];

    /** @var array<class-string> */
    private $providerTypes = [
        Type\AboutPage::class,
        Type\Answer::class,
        Type\APIReference::class,
        Type\Article::class,
        Type\AudioObject::class,
        Type\BankAccount::class,
        Type\Barcode::class,
        Type\Blog::class,
        Type\BlogPosting::class,
        Type\Book::class,
        Type\BookSeries::class,
        Type\BroadcastService::class,
        Type\BusReservation::class,
        Type\BusTrip::class,
        Type\CableOrSatelliteService::class,
        Type\CheckoutPage::class,
        Type\ClaimReview::class,
        Type\Clip::class,
        Type\CollectionPage::class,
        Type\Comment::class,
        Type\ContactPage::class,
        Type\Conversation::class,
        Type\Course::class,
        Type\CreativeWork::class,
        Type\CreativeWorkSeason::class,
        Type\CreativeWorkSeries::class,
        Type\CreditCard::class,
        Type\CurrencyConversionService::class,
        Type\DataCatalog::class,
        Type\DataDownload::class,
        Type\DataFeed::class,
        Type\Dataset::class,
        Type\DepositAccount::class,
        Type\DigitalDocument::class,
        Type\DiscussionForumPosting::class,
        Type\EmailMessage::class,
        Type\Episode::class,
        Type\EventReservation::class,
        Type\FAQPage::class,
        Type\FinancialProduct::class,
        Type\Flight::class,
        Type\FlightReservation::class,
        Type\FoodEstablishmentReservation::class,
        Type\FoodService::class,
        Type\Game::class,
        Type\GovernmentService::class,
        Type\HowTo::class,
        Type\HowToDirection::class,
        Type\HowToSection::class,
        Type\HowToStep::class,
        Type\HowToTip::class,
        Type\ImageGallery::class,
        Type\ImageObject::class,
        Type\InvestmentOrDeposit::class,
        Type\Invoice::class,
        Type\ItemPage::class,
        Type\LiveBlogPosting::class,
        Type\LoanOrCredit::class,
        Type\LodgingReservation::class,
        Type\Map::class,
        Type\MediaGallery::class,
        Type\MediaObject::class,
        Type\Menu::class,
        Type\MenuSection::class,
        Type\Message::class,
        Type\MobileApplication::class,
        Type\Movie::class,
        Type\MovieClip::class,
        Type\MovieSeries::class,
        Type\MusicAlbum::class,
        Type\MusicComposition::class,
        Type\MusicPlaylist::class,
        Type\MusicRecording::class,
        Type\MusicRelease::class,
        Type\MusicVideoObject::class,
        Type\NewsArticle::class,
        Type\NoteDigitalDocument::class,
        Type\Painting::class,
        Type\ParcelDelivery::class,
        Type\PaymentCard::class,
        Type\PaymentService::class,
        Type\Periodical::class,
        Type\Photograph::class,
        Type\PresentationDigitalDocument::class,
        Type\ProfilePage::class,
        Type\PublicationIssue::class,
        Type\PublicationVolume::class,
        Type\QAPage::class,
        Type\Question::class,
        Type\RadioClip::class,
        Type\RadioEpisode::class,
        Type\RadioSeason::class,
        Type\RadioSeries::class,
        Type\Recipe::class,
        Type\RentalCarReservation::class,
        Type\Report::class,
        Type\Reservation::class,
        Type\ReservationPackage::class,
        Type\Review::class,
        Type\ScholarlyArticle::class,
        Type\Sculpture::class,
        Type\SearchResultsPage::class,
        Type\Service::class,
        Type\SiteNavigationElement::class,
        Type\SocialMediaPosting::class,
        Type\SoftwareApplication::class,
        Type\SoftwareSourceCode::class,
        Type\SpreadsheetDigitalDocument::class,
        Type\Table::class,
        Type\TaxiReservation::class,
        Type\TaxiService::class,
        Type\TechArticle::class,
        Type\TextDigitalDocument::class,
        Type\TrainReservation::class,
        Type\TrainTrip::class,
        Type\Trip::class,
        Type\TVClip::class,
        Type\TVEpisode::class,
        Type\TVSeason::class,
        Type\TVSeries::class,
        Type\VideoGallery::class,
        Type\VideoGame::class,
        Type\VideoGameClip::class,
        Type\VideoGameSeries::class,
        Type\VideoObject::class,
        Type\VisualArtwork::class,
        Type\WebApplication::class,
        Type\WebPage::class,
        Type\WebPageElement::class,
        Type\WebSite::class,
        Type\WPAdBlock::class,
        Type\WPFooter::class,
        Type\WPHeader::class,
        Type\WPSideBar::class,
    ];

    /** @var array<class-string> */
    private $sportTypes = [
        Type\SportsEvent::class,
        Type\SportsOrganization::class,
        Type\SportsTeam::class,
    ];

    /** @var array<class-string> */
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
            /* @see https://github.com/schemaorg/schemaorg/issues/2499 */
            $event->registerAdditionalProperty('gender');

            /* from official to pending in schema version 3.7 */
            $event->registerAdditionalProperty('jobTitle');
        }

        if (\in_array($type, $this->hasEnergyConsumptionDetails)) {
            /* from official to pending in schema version 11.0 */
            $event->registerAdditionalProperty('hasEnergyConsumptionDetails');
        }
        if (\in_array($type, $this->ineligibleRegionTypes)) {
            /* from official to pending in schema version 4.0 */
            $event->registerAdditionalProperty('ineligibleRegion');
        }

        if (\in_array($type, $this->occupationalCategoryTypes)) {
            /* from official to pending in schema version 7.0 */
            $event->registerAdditionalProperty('occupationalCategory');
        }

        if (\in_array($type, $this->providerTypes, true)) {
            // from official to pending in schema version 14.0
            $event->registerAdditionalProperty('provider');
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
