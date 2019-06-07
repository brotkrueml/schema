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
 * Reference documentation for application programming interfaces (APIs).
 *
 * schema.org version 3.6
 */
class APIReferenceViewHelper extends TechArticleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('assemblyVersion', 'mixed', 'Associated product/technology version. e.g., .NET Framework 4.5.');
        $this->registerArgument('executableLibraryName', 'mixed', 'Library file name e.g., mscorlib.dll, system.web.dll.');
        $this->registerArgument('programmingModel', 'mixed', 'Indicates whether API is managed or unmanaged.');
        $this->registerArgument('targetPlatform', 'mixed', 'Type of app development: phone, Metro style, desktop, XBox, etc.');
    }
}
