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
 * A software application.
 *
 * schema.org version 3.6
 */
class SoftwareApplication extends CreativeWork
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('applicationCategory', 'applicationSubCategory', 'applicationSuite', 'availableOnDevice', 'countriesNotSupported', 'countriesSupported', 'downloadUrl', 'featureList', 'fileSize', 'installUrl', 'memoryRequirements', 'operatingSystem', 'permissions', 'processorRequirements', 'releaseNotes', 'screenshot', 'softwareAddOn', 'softwareHelp', 'softwareRequirements', 'softwareVersion', 'storageRequirements', 'supportingData');
    }
}
