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
 * An electronic file or document.
 *
 * schema.org version 3.6
 */
class DigitalDocumentViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('hasDigitalDocumentPermission', 'mixed', 'A permission related to the access to this document (e.g. permission to read or write an electronic document). For a public document, specify a grantee with an Audience with audienceType equal to "public".');
    }
}
