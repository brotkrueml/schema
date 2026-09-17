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
 * Enumeration(s) for use with measurementMethod.
 */
enum MeasurementMethodEnum implements EnumerationInterface
{
    /**
     * An example MeasurementMethodEnum (to remove when real enums are added).
     */
    case ExampleMeasurementMethodEnum;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
