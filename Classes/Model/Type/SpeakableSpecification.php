<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A SpeakableSpecification indicates (typically via xpath or cssSelector) sections of a document that are highlighted as particularly speakable. Instances of this type are expected to be used primarily as values of the speakable property.
 *
 * schema.org version 3.6
 */
class SpeakableSpecification extends Intangible
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('cssSelector', 'xpath');
    }
}
