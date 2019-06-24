<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\TypeTrait;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
trait SoftwareApplicationTrait
{
    protected $applicationCategory;
    protected $applicationSubCategory;
    protected $applicationSuite;
    protected $availableOnDevice;
    protected $countriesNotSupported;
    protected $countriesSupported;
    protected $downloadUrl;
    protected $featureList;
    protected $fileSize;
    protected $installUrl;
    protected $memoryRequirements;
    protected $operatingSystem;
    protected $permissions;
    protected $processorRequirements;
    protected $releaseNotes;
    protected $screenshot;
    protected $softwareAddOn;
    protected $softwareHelp;
    protected $softwareRequirements;
    protected $softwareVersion;
    protected $storageRequirements;
    protected $supportingData;
}
