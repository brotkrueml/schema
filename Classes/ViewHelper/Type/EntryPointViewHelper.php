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
 * An entry point, within some Web-based protocol.
 *
 * schema.org version 3.6
 */
class EntryPointViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('actionApplication', 'mixed', 'An application that can complete the request.');
        $this->registerArgument('actionPlatform', 'mixed', 'The high level platform(s) where the Action can be performed for the given URL. To specify a specific application or operating system instance, use actionApplication.');
        $this->registerArgument('contentType', 'mixed', 'The supported content type(s) for an EntryPoint response.');
        $this->registerArgument('encodingType', 'mixed', 'The supported encoding type(s) for an EntryPoint request.');
        $this->registerArgument('httpMethod', 'mixed', 'An HTTP method that specifies the appropriate HTTP method for a request to an HTTP EntryPoint. Values are capitalized strings as used in HTTP.');
        $this->registerArgument('urlTemplate', 'mixed', 'An url template (RFC6570) that will be used to construct the target of the execution of the action.');
    }
}
