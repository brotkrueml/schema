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
 * Enumerates common size systems for different categories of products, for example "EN-13402" or "UK" for wearables or "Imperial" for screws.
 */
enum SizeSystemEnumeration implements EnumerationInterface
{
    /**
     * Imperial size system.
     */
    case SizeSystemImperial;

    /**
     * Metric size system.
     */
    case SizeSystemMetric;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
