<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\ViewHelpers\Type;

use Brotkrueml\Schema\Core\ViewHelpers\AbstractTypeViewHelper;

/**
 * A DeliveryTimeSettings represents re-usable pieces of shipping information, relating to timing. It is designed for publication on an URL that may be referenced via the shippingSettingsLink property of an OfferShippingDetails. Several occurrences can be published, distinguished (and identified/referenced) by their different values for transitTimeLabel.
 *
 * @deprecated This type has been superseded by ShippingConditions with schema.org v29.0
 * @see https://schema.org/DeliveryTimeSettings
 * @todo Remove with schema 4.0.0
 */
final class DeliveryTimeSettingsViewHelper extends AbstractTypeViewHelper
{
    protected string $type = 'DeliveryTimeSettings';
}
