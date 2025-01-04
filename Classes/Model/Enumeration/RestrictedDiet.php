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
 * A diet restricted to certain foods or preparations for cultural, religious, health or lifestyle reasons.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum RestrictedDiet implements EnumerationInterface
{
    /**
     * A diet appropriate for people with diabetes.
     */
    case DiabeticDiet;

    /**
     * A diet exclusive of gluten.
     */
    case GlutenFreeDiet;

    /**
     * A diet conforming to Islamic dietary practices.
     */
    case HalalDiet;

    /**
     * A diet conforming to Hindu dietary practices, in particular, beef-free.
     */
    case HinduDiet;

    /**
     * A diet conforming to Jewish dietary practices.
     */
    case KosherDiet;

    /**
     * A diet focused on reduced calorie intake.
     */
    case LowCalorieDiet;

    /**
     * A diet focused on reduced fat and cholesterol intake.
     */
    case LowFatDiet;

    /**
     * A diet appropriate for people with lactose intolerance.
     */
    case LowLactoseDiet;

    /**
     * A diet focused on reduced sodium intake.
     */
    case LowSaltDiet;

    /**
     * A diet exclusive of all animal products.
     */
    case VeganDiet;

    /**
     * A diet exclusive of animal meat.
     */
    case VegetarianDiet;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
