<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Enumeration;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;

/**
 * Enumerates common size groups (also known as "size types") for wearable products.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum WearableSizeGroupEnumeration implements EnumerationInterface
{
    /**
     * Size group "Big" for wearables.
     */
    case WearableSizeGroupBig;

    /**
     * Size group "Boys" for wearables.
     */
    case WearableSizeGroupBoys;

    /**
     * Size group "Extra Short" for wearables.
     */
    case WearableSizeGroupExtraShort;

    /**
     * Size group "Extra Tall" for wearables.
     */
    case WearableSizeGroupExtraTall;

    /**
     * Size group "Girls" for wearables.
     */
    case WearableSizeGroupGirls;

    /**
     * Size group "Husky" (or "Stocky") for wearables.
     */
    case WearableSizeGroupHusky;

    /**
     * Size group "Infants" for wearables.
     */
    case WearableSizeGroupInfants;

    /**
     * Size group "Juniors" for wearables.
     */
    case WearableSizeGroupJuniors;

    /**
     * Size group "Maternity" for wearables.
     */
    case WearableSizeGroupMaternity;

    /**
     * Size group "Mens" for wearables.
     */
    case WearableSizeGroupMens;

    /**
     * Size group "Misses" (also known as "Missy") for wearables.
     */
    case WearableSizeGroupMisses;

    /**
     * Size group "Petite" for wearables.
     */
    case WearableSizeGroupPetite;

    /**
     * Size group "Plus" for wearables.
     */
    case WearableSizeGroupPlus;

    /**
     * Size group "Regular" for wearables.
     */
    case WearableSizeGroupRegular;

    /**
     * Size group "Short" for wearables.
     */
    case WearableSizeGroupShort;

    /**
     * Size group "Tall" for wearables.
     */
    case WearableSizeGroupTall;

    /**
     * Size group "Womens" for wearables.
     */
    case WearableSizeGroupWomens;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
