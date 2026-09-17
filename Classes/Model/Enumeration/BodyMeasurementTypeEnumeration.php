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
 * Enumerates types (or dimensions) of a person's body measurements, for example for fitting of clothes.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum BodyMeasurementTypeEnumeration implements EnumerationInterface
{
    /**
     * Arm length (measured between arms/shoulder line intersection and the prominent wrist bone). Used, for example, to fit shirts.
     */
    case BodyMeasurementArm;

    /**
     * Maximum girth of bust. Used, for example, to fit women's suits.
     */
    case BodyMeasurementBust;

    /**
     * Maximum girth of chest. Used, for example, to fit men's suits.
     */
    case BodyMeasurementChest;

    /**
     * Foot length (measured between end of the most prominent toe and the most prominent part of the heel). Used, for example, to measure socks.
     */
    case BodyMeasurementFoot;

    /**
     * Maximum hand girth (measured over the knuckles of the open right hand excluding thumb, fingers together). Used, for example, to fit gloves.
     */
    case BodyMeasurementHand;

    /**
     * Maximum girth of head above the ears. Used, for example, to fit hats.
     */
    case BodyMeasurementHead;

    /**
     * Body height (measured between crown of head and soles of feet). Used, for example, to fit jackets.
     */
    case BodyMeasurementHeight;

    /**
     * Girth of hips (measured around the buttocks). Used, for example, to fit skirts.
     */
    case BodyMeasurementHips;

    /**
     * Inside leg (measured between crotch and soles of feet). Used, for example, to fit pants.
     */
    case BodyMeasurementInsideLeg;

    /**
     * Girth of neck. Used, for example, to fit shirts.
     */
    case BodyMeasurementNeck;

    /**
     * Girth of body just below the bust. Used, for example, to fit women's swimwear.
     */
    case BodyMeasurementUnderbust;

    /**
     * Girth of natural waistline (between hip bones and lower ribs). Used, for example, to fit pants.
     */
    case BodyMeasurementWaist;

    /**
     * Body weight. Used, for example, to measure pantyhose.
     */
    case BodyMeasurementWeight;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
