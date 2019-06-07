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
 * A software application.
 *
 * schema.org version 3.6
 */
class SoftwareApplicationViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('applicationCategory', 'mixed', 'Type of software application, e.g. \'Game, Multimedia\'.');
        $this->registerArgument('applicationSubCategory', 'mixed', 'Subcategory of the application, e.g. \'Arcade Game\'.');
        $this->registerArgument('applicationSuite', 'mixed', 'The name of the application suite to which the application belongs (e.g. Excel belongs to Office).');
        $this->registerArgument('availableOnDevice', 'mixed', 'Device required to run the application. Used in cases where a specific make/model is required to run the application.');
        $this->registerArgument('countriesNotSupported', 'mixed', 'Countries for which the application is not supported. You can also provide the two-letter ISO 3166-1 alpha-2 country code.');
        $this->registerArgument('countriesSupported', 'mixed', 'Countries for which the application is supported. You can also provide the two-letter ISO 3166-1 alpha-2 country code.');
        $this->registerArgument('downloadUrl', 'mixed', 'If the file can be downloaded, URL to download the binary.');
        $this->registerArgument('featureList', 'mixed', 'Features or modules provided by this application (and possibly required by other applications).');
        $this->registerArgument('fileSize', 'mixed', 'Size of the application / package (e.g. 18MB). In the absence of a unit (MB, KB etc.), KB will be assumed.');
        $this->registerArgument('installUrl', 'mixed', 'URL at which the app may be installed, if different from the URL of the item.');
        $this->registerArgument('memoryRequirements', 'mixed', 'Minimum memory requirements.');
        $this->registerArgument('operatingSystem', 'mixed', 'Operating systems supported (Windows 7, OSX 10.6, Android 1.6).');
        $this->registerArgument('permissions', 'mixed', 'Permission(s) required to run the app (for example, a mobile app may require full internet access or may run only on wifi).');
        $this->registerArgument('processorRequirements', 'mixed', 'Processor architecture required to run the application (e.g. IA64).');
        $this->registerArgument('releaseNotes', 'mixed', 'Description of what changed in this version.');
        $this->registerArgument('screenshot', 'mixed', 'A link to a screenshot image of the app.');
        $this->registerArgument('softwareAddOn', 'mixed', 'Additional content for a software application.');
        $this->registerArgument('softwareHelp', 'mixed', 'Software application help.');
        $this->registerArgument('softwareRequirements', 'mixed', 'Component dependency requirements for application. This includes runtime environments and shared libraries that are not included in the application distribution package, but required to run the application (Examples: DirectX, Java or .NET runtime).');
        $this->registerArgument('softwareVersion', 'mixed', 'Version of the software instance.');
        $this->registerArgument('storageRequirements', 'mixed', 'Storage requirements (free space required).');
        $this->registerArgument('supportingData', 'mixed', 'Supporting data for a SoftwareApplication.');
    }
}
