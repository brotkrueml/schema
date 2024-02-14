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
use Brotkrueml\Schema\Model\Type\AboutPage;
use Brotkrueml\Schema\Model\Type\ActionAccessSpecification;
use Brotkrueml\Schema\Model\Type\AggregateOffer;
use Brotkrueml\Schema\Model\Type\Answer;
use Brotkrueml\Schema\Model\Type\APIReference;
use Brotkrueml\Schema\Model\Type\Article;
use Brotkrueml\Schema\Model\Type\AudioObject;
use Brotkrueml\Schema\Model\Type\BankAccount;
use Brotkrueml\Schema\Model\Type\Barcode;
use Brotkrueml\Schema\Model\Type\Blog;
use Brotkrueml\Schema\Model\Type\BlogPosting;
use Brotkrueml\Schema\Model\Type\Book;
use Brotkrueml\Schema\Model\Type\BookSeries;
use Brotkrueml\Schema\Model\Type\BroadcastEvent;
use Brotkrueml\Schema\Model\Type\BroadcastService;
use Brotkrueml\Schema\Model\Type\BusReservation;
use Brotkrueml\Schema\Model\Type\BusTrip;
use Brotkrueml\Schema\Model\Type\CableOrSatelliteService;
use Brotkrueml\Schema\Model\Type\Car;
use Brotkrueml\Schema\Model\Type\CheckoutPage;
use Brotkrueml\Schema\Model\Type\ClaimReview;
use Brotkrueml\Schema\Model\Type\Clip;
use Brotkrueml\Schema\Model\Type\CollectionPage;
use Brotkrueml\Schema\Model\Type\Comment;
use Brotkrueml\Schema\Model\Type\ContactPage;
use Brotkrueml\Schema\Model\Type\Conversation;
use Brotkrueml\Schema\Model\Type\Course;
use Brotkrueml\Schema\Model\Type\CreativeWork;
use Brotkrueml\Schema\Model\Type\CreativeWorkSeason;
use Brotkrueml\Schema\Model\Type\CreativeWorkSeries;
use Brotkrueml\Schema\Model\Type\CreditCard;
use Brotkrueml\Schema\Model\Type\CurrencyConversionService;
use Brotkrueml\Schema\Model\Type\DataCatalog;
use Brotkrueml\Schema\Model\Type\DataDownload;
use Brotkrueml\Schema\Model\Type\DataFeed;
use Brotkrueml\Schema\Model\Type\Dataset;
use Brotkrueml\Schema\Model\Type\DeliveryChargeSpecification;
use Brotkrueml\Schema\Model\Type\Demand;
use Brotkrueml\Schema\Model\Type\DepositAccount;
use Brotkrueml\Schema\Model\Type\DigitalDocument;
use Brotkrueml\Schema\Model\Type\DiscussionForumPosting;
use Brotkrueml\Schema\Model\Type\EmailMessage;
use Brotkrueml\Schema\Model\Type\Episode;
use Brotkrueml\Schema\Model\Type\EventReservation;
use Brotkrueml\Schema\Model\Type\FAQPage;
use Brotkrueml\Schema\Model\Type\FinancialProduct;
use Brotkrueml\Schema\Model\Type\Flight;
use Brotkrueml\Schema\Model\Type\FlightReservation;
use Brotkrueml\Schema\Model\Type\FoodEstablishmentReservation;
use Brotkrueml\Schema\Model\Type\FoodService;
use Brotkrueml\Schema\Model\Type\Game;
use Brotkrueml\Schema\Model\Type\GovernmentService;
use Brotkrueml\Schema\Model\Type\HowTo;
use Brotkrueml\Schema\Model\Type\HowToDirection;
use Brotkrueml\Schema\Model\Type\HowToSection;
use Brotkrueml\Schema\Model\Type\HowToStep;
use Brotkrueml\Schema\Model\Type\HowToTip;
use Brotkrueml\Schema\Model\Type\ImageGallery;
use Brotkrueml\Schema\Model\Type\ImageObject;
use Brotkrueml\Schema\Model\Type\IndividualProduct;
use Brotkrueml\Schema\Model\Type\InvestmentOrDeposit;
use Brotkrueml\Schema\Model\Type\Invoice;
use Brotkrueml\Schema\Model\Type\ItemPage;
use Brotkrueml\Schema\Model\Type\JobPosting;
use Brotkrueml\Schema\Model\Type\LiveBlogPosting;
use Brotkrueml\Schema\Model\Type\LoanOrCredit;
use Brotkrueml\Schema\Model\Type\LodgingReservation;
use Brotkrueml\Schema\Model\Type\Map;
use Brotkrueml\Schema\Model\Type\MediaGallery;
use Brotkrueml\Schema\Model\Type\MediaObject;
use Brotkrueml\Schema\Model\Type\Menu;
use Brotkrueml\Schema\Model\Type\MenuSection;
use Brotkrueml\Schema\Model\Type\Message;
use Brotkrueml\Schema\Model\Type\MobileApplication;
use Brotkrueml\Schema\Model\Type\Movie;
use Brotkrueml\Schema\Model\Type\MovieClip;
use Brotkrueml\Schema\Model\Type\MovieSeries;
use Brotkrueml\Schema\Model\Type\MusicAlbum;
use Brotkrueml\Schema\Model\Type\MusicComposition;
use Brotkrueml\Schema\Model\Type\MusicPlaylist;
use Brotkrueml\Schema\Model\Type\MusicRecording;
use Brotkrueml\Schema\Model\Type\MusicRelease;
use Brotkrueml\Schema\Model\Type\MusicVideoObject;
use Brotkrueml\Schema\Model\Type\NewsArticle;
use Brotkrueml\Schema\Model\Type\NoteDigitalDocument;
use Brotkrueml\Schema\Model\Type\Occupation;
use Brotkrueml\Schema\Model\Type\Offer;
use Brotkrueml\Schema\Model\Type\Painting;
use Brotkrueml\Schema\Model\Type\ParcelDelivery;
use Brotkrueml\Schema\Model\Type\PaymentCard;
use Brotkrueml\Schema\Model\Type\PaymentService;
use Brotkrueml\Schema\Model\Type\Periodical;
use Brotkrueml\Schema\Model\Type\Person;
use Brotkrueml\Schema\Model\Type\Photograph;
use Brotkrueml\Schema\Model\Type\PresentationDigitalDocument;
use Brotkrueml\Schema\Model\Type\Product;
use Brotkrueml\Schema\Model\Type\ProductModel;
use Brotkrueml\Schema\Model\Type\ProfilePage;
use Brotkrueml\Schema\Model\Type\PublicationIssue;
use Brotkrueml\Schema\Model\Type\PublicationVolume;
use Brotkrueml\Schema\Model\Type\QAPage;
use Brotkrueml\Schema\Model\Type\Question;
use Brotkrueml\Schema\Model\Type\RadioClip;
use Brotkrueml\Schema\Model\Type\RadioEpisode;
use Brotkrueml\Schema\Model\Type\RadioSeason;
use Brotkrueml\Schema\Model\Type\RadioSeries;
use Brotkrueml\Schema\Model\Type\Recipe;
use Brotkrueml\Schema\Model\Type\RentalCarReservation;
use Brotkrueml\Schema\Model\Type\Report;
use Brotkrueml\Schema\Model\Type\Reservation;
use Brotkrueml\Schema\Model\Type\ReservationPackage;
use Brotkrueml\Schema\Model\Type\Review;
use Brotkrueml\Schema\Model\Type\ScholarlyArticle;
use Brotkrueml\Schema\Model\Type\ScreeningEvent;
use Brotkrueml\Schema\Model\Type\Sculpture;
use Brotkrueml\Schema\Model\Type\SearchResultsPage;
use Brotkrueml\Schema\Model\Type\Service;
use Brotkrueml\Schema\Model\Type\SiteNavigationElement;
use Brotkrueml\Schema\Model\Type\SocialMediaPosting;
use Brotkrueml\Schema\Model\Type\SoftwareApplication;
use Brotkrueml\Schema\Model\Type\SoftwareSourceCode;
use Brotkrueml\Schema\Model\Type\SomeProducts;
use Brotkrueml\Schema\Model\Type\SportsEvent;
use Brotkrueml\Schema\Model\Type\SportsOrganization;
use Brotkrueml\Schema\Model\Type\SportsTeam;
use Brotkrueml\Schema\Model\Type\SpreadsheetDigitalDocument;
use Brotkrueml\Schema\Model\Type\Table;
use Brotkrueml\Schema\Model\Type\TaxiReservation;
use Brotkrueml\Schema\Model\Type\TaxiService;
use Brotkrueml\Schema\Model\Type\TechArticle;
use Brotkrueml\Schema\Model\Type\TextDigitalDocument;
use Brotkrueml\Schema\Model\Type\TrainReservation;
use Brotkrueml\Schema\Model\Type\TrainTrip;
use Brotkrueml\Schema\Model\Type\Trip;
use Brotkrueml\Schema\Model\Type\TVClip;
use Brotkrueml\Schema\Model\Type\TVEpisode;
use Brotkrueml\Schema\Model\Type\TVSeason;
use Brotkrueml\Schema\Model\Type\TVSeries;
use Brotkrueml\Schema\Model\Type\Vehicle;
use Brotkrueml\Schema\Model\Type\VideoGallery;
use Brotkrueml\Schema\Model\Type\VideoGame;
use Brotkrueml\Schema\Model\Type\VideoGameClip;
use Brotkrueml\Schema\Model\Type\VideoGameSeries;
use Brotkrueml\Schema\Model\Type\VideoObject;
use Brotkrueml\Schema\Model\Type\VisualArtwork;
use Brotkrueml\Schema\Model\Type\WebApplication;
use Brotkrueml\Schema\Model\Type\WebPage;
use Brotkrueml\Schema\Model\Type\WebPageElement;
use Brotkrueml\Schema\Model\Type\WebSite;
use Brotkrueml\Schema\Model\Type\WPAdBlock;
use Brotkrueml\Schema\Model\Type\WPFooter;
use Brotkrueml\Schema\Model\Type\WPHeader;
use Brotkrueml\Schema\Model\Type\WPSideBar;

/**
 * The following properties has been available as official
 * but were moved because of reasons to pending again.
 * These properties are registered again to avoid
 * breaking changes.
 *
 * @todo Remove with schema 4.0.0
 * @internal
 */
final class RegisterTypePropertiesMovedFromOfficialToPending
{
    /**
     * @var list<class-string>
     */
    private array $hasEnergyConsumptionDetails = [
        Car::class,
        IndividualProduct::class,
        Product::class,
        ProductModel::class,
        SomeProducts::class,
        Vehicle::class,
    ];

    /**
     * @var list<class-string>
     */
    private array $ineligibleRegionTypes = [
        ActionAccessSpecification::class,
        AggregateOffer::class,
        DeliveryChargeSpecification::class,
        Demand::class,
        Offer::class,
    ];

    /**
     * @var list<class-string>
     */
    private array $occupationalCategoryTypes = [
        JobPosting::class,
        Occupation::class,
    ];

    /**
     * @var list<class-string>
     */
    private array $providerTypes = [
        AboutPage::class,
        Answer::class,
        APIReference::class,
        Article::class,
        AudioObject::class,
        BankAccount::class,
        Barcode::class,
        Blog::class,
        BlogPosting::class,
        Book::class,
        BookSeries::class,
        BroadcastService::class,
        BusReservation::class,
        BusTrip::class,
        CableOrSatelliteService::class,
        CheckoutPage::class,
        ClaimReview::class,
        Clip::class,
        CollectionPage::class,
        Comment::class,
        ContactPage::class,
        Conversation::class,
        Course::class,
        CreativeWork::class,
        CreativeWorkSeason::class,
        CreativeWorkSeries::class,
        CreditCard::class,
        CurrencyConversionService::class,
        DataCatalog::class,
        DataDownload::class,
        DataFeed::class,
        Dataset::class,
        DepositAccount::class,
        DigitalDocument::class,
        DiscussionForumPosting::class,
        EmailMessage::class,
        Episode::class,
        EventReservation::class,
        FAQPage::class,
        FinancialProduct::class,
        Flight::class,
        FlightReservation::class,
        FoodEstablishmentReservation::class,
        FoodService::class,
        Game::class,
        GovernmentService::class,
        HowTo::class,
        HowToDirection::class,
        HowToSection::class,
        HowToStep::class,
        HowToTip::class,
        ImageGallery::class,
        ImageObject::class,
        InvestmentOrDeposit::class,
        Invoice::class,
        ItemPage::class,
        LiveBlogPosting::class,
        LoanOrCredit::class,
        LodgingReservation::class,
        Map::class,
        MediaGallery::class,
        MediaObject::class,
        Menu::class,
        MenuSection::class,
        Message::class,
        MobileApplication::class,
        Movie::class,
        MovieClip::class,
        MovieSeries::class,
        MusicAlbum::class,
        MusicComposition::class,
        MusicPlaylist::class,
        MusicRecording::class,
        MusicRelease::class,
        MusicVideoObject::class,
        NewsArticle::class,
        NoteDigitalDocument::class,
        Painting::class,
        ParcelDelivery::class,
        PaymentCard::class,
        PaymentService::class,
        Periodical::class,
        Photograph::class,
        PresentationDigitalDocument::class,
        ProfilePage::class,
        PublicationIssue::class,
        PublicationVolume::class,
        QAPage::class,
        Question::class,
        RadioClip::class,
        RadioEpisode::class,
        RadioSeason::class,
        RadioSeries::class,
        Recipe::class,
        RentalCarReservation::class,
        Report::class,
        Reservation::class,
        ReservationPackage::class,
        Review::class,
        ScholarlyArticle::class,
        Sculpture::class,
        SearchResultsPage::class,
        Service::class,
        SiteNavigationElement::class,
        SocialMediaPosting::class,
        SoftwareApplication::class,
        SoftwareSourceCode::class,
        SpreadsheetDigitalDocument::class,
        Table::class,
        TaxiReservation::class,
        TaxiService::class,
        TechArticle::class,
        TextDigitalDocument::class,
        TrainReservation::class,
        TrainTrip::class,
        Trip::class,
        TVClip::class,
        TVEpisode::class,
        TVSeason::class,
        TVSeries::class,
        VideoGallery::class,
        VideoGame::class,
        VideoGameClip::class,
        VideoGameSeries::class,
        VideoObject::class,
        VisualArtwork::class,
        WebApplication::class,
        WebPage::class,
        WebPageElement::class,
        WebSite::class,
        WPAdBlock::class,
        WPFooter::class,
        WPHeader::class,
        WPSideBar::class,
    ];

    /**
     * @var list<class-string>
     */
    private array $sportTypes = [
        SportsEvent::class,
        SportsOrganization::class,
        SportsTeam::class,
    ];

    /**
     * @var list<class-string>
     */
    private array $subtitleLanguageTypes = [
        BroadcastEvent::class,
        Movie::class,
        ScreeningEvent::class,
        TVEpisode::class,
    ];

    public function __invoke(RegisterAdditionalTypePropertiesEvent $event): void
    {
        $type = $event->getType();

        if ($type === Person::class) {
            // @see https://github.com/schemaorg/schemaorg/issues/2499
            $event->registerAdditionalProperty('gender');

            // from official to pending in schema version 3.7
            $event->registerAdditionalProperty('jobTitle');
        }

        if (\in_array($type, $this->hasEnergyConsumptionDetails, true)) {
            // from official to pending in schema version 11.0
            $event->registerAdditionalProperty('hasEnergyConsumptionDetails');
        }
        if (\in_array($type, $this->ineligibleRegionTypes, true)) {
            // from official to pending in schema version 4.0
            $event->registerAdditionalProperty('ineligibleRegion');
        }

        if (\in_array($type, $this->occupationalCategoryTypes, true)) {
            // from official to pending in schema version 7.0
            $event->registerAdditionalProperty('occupationalCategory');
        }

        if (\in_array($type, $this->providerTypes, true)) {
            // from official to pending in schema version 14.0
            $event->registerAdditionalProperty('provider');
        }

        if (\in_array($type, $this->sportTypes, true)) {
            // from official to pending in schema version 5.0
            $event->registerAdditionalProperty('sport');
        }

        if (\in_array($type, $this->subtitleLanguageTypes, true)) {
            // from official to pending in schema version 4.0
            $event->registerAdditionalProperty('subtitleLanguage');
        }
    }
}
