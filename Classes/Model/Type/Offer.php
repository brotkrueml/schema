<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Type;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\AbstractType;

/**
 * An offer to transfer some rights to an item or to provide a service — for example, an offer to sell tickets to an event, to rent the DVD of a movie, to stream a TV show over the internet, to repair a motorcycle, or to loan a book.
 *
 * Note: As the businessFunction property, which identifies the form of offer (e.g. sell, lease, repair, dispose), defaults to http://purl.org/goodrelations/v1#Sell; an Offer without a defined businessFunction value can be assumed to be an offer to sell.
 *
 * For [GTIN](http://www.gs1.org/barcodes/technical/idkeys/gtin)-related fields, see [Check Digit calculator](http://www.gs1.org/barcodes/support/check_digit_calculator) and [validation guide](http://www.gs1us.org/resources/standards/gtin-validation-guide) from [GS1](http://www.gs1.org/).
 */
#[Type('Offer')]
final class Offer extends AbstractType
{
    protected static array $propertyNames = [
        'acceptedPaymentMethod',
        'addOn',
        'additionalProperty',
        'additionalType',
        'advanceBookingRequirement',
        'aggregateRating',
        'alternateName',
        'areaServed',
        'availability',
        'availabilityEnds',
        'availabilityStarts',
        'availableAtOrFrom',
        'availableDeliveryMethod',
        'businessFunction',
        'category',
        'deliveryLeadTime',
        'description',
        'disambiguatingDescription',
        'eligibleCustomerType',
        'eligibleDuration',
        'eligibleQuantity',
        'eligibleRegion',
        'eligibleTransactionVolume',
        'gtin12',
        'gtin13',
        'gtin14',
        'gtin8',
        'identifier',
        'image',
        'includesObject',
        'inventoryLevel',
        'isFamilyFriendly',
        'itemCondition',
        'itemOffered',
        'mainEntityOfPage',
        'mpn',
        'name',
        'offeredBy',
        'potentialAction',
        'price',
        'priceCurrency',
        'priceSpecification',
        'priceValidUntil',
        'review',
        'sameAs',
        'seller',
        'serialNumber',
        'sku',
        'subjectOf',
        'url',
        'validForMemberTier',
        'validFrom',
        'validThrough',
        'warranty',
    ];
}
