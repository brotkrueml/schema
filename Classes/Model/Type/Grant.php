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
 * A grant, typically financial or otherwise quantifiable, of resources. Typically a funder sponsors some MonetaryAmount to an Organization or Person,
 * sometimes not necessarily via a dedicated or long-lived Project, resulting in one or more outputs, or fundedItems. For financial sponsorship, indicate the funder of a MonetaryGrant. For non-financial support, indicate sponsor of Grants of resources (e.g. office space).
 *
 * Grants support  activities directed towards some agreed collective goals, often but not always organized as Projects. Long-lived projects are sometimes sponsored by a variety of grants over time, but it is also common for a project to be associated with a single grant.
 *
 * The amount of a Grant is represented using amount as a MonetaryAmount.
 */
#[Type('Grant')]
final class Grant extends AbstractType
{
    protected static array $propertyNames = [
        'additionalType',
        'alternateName',
        'description',
        'disambiguatingDescription',
        'fundedItem',
        'funder',
        'identifier',
        'image',
        'mainEntityOfPage',
        'name',
        'owner',
        'potentialAction',
        'sameAs',
        'sponsor',
        'subjectOf',
        'url',
    ];
}
