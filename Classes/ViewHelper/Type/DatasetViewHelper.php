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
 * A body of structured information describing some topic(s) of interest.
 *
 * schema.org version 3.6
 */
class DatasetViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('distribution', 'mixed', 'A downloadable form of this dataset, at a specific location, in a specific format.');
        $this->registerArgument('includedInDataCatalog', 'mixed', 'A data catalog which contains this dataset.');
        $this->registerArgument('issn', 'mixed', 'The International Standard Serial Number (ISSN) that identifies this serial publication. You can repeat this property to identify different formats of, or the linking ISSN (ISSN-L) for, this serial publication.');
    }
}
