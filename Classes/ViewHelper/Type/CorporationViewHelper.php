<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * Organization: A business corporation.
 *
 * schema.org version 3.6
 */
class CorporationViewHelper extends OrganizationViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('tickerSymbol', 'mixed', 'The exchange traded instrument associated with a Corporation object. The tickerSymbol is expressed as an exchange and an instrument name separated by a space character. For the exchange component of the tickerSymbol attribute, we recommend using the controlled vocabulary of Market Identifier Codes (MIC) specified in ISO15022.');
    }
}
