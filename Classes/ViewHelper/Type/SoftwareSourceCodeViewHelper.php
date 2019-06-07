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
 * Computer programming source code. Example: Full (compile ready) solutions, code snippet samples, scripts, templates.
 *
 * schema.org version 3.6
 */
class SoftwareSourceCodeViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('codeRepository', 'mixed', 'Link to the repository where the un-compiled, human readable code and related code is located (SVN, github, CodePlex).');
        $this->registerArgument('codeSampleType', 'mixed', 'What type of code sample: full (compile ready) solution, code snippet, inline code, scripts, template.');
        $this->registerArgument('programmingLanguage', 'mixed', 'The computer programming language.');
        $this->registerArgument('runtimePlatform', 'mixed', 'Runtime platform or script interpreter dependencies (Example - Java v1, Python2.3, .Net Framework 3.0).');
        $this->registerArgument('targetProduct', 'mixed', 'Target Operating System / Product to which the code applies.  If applies to several versions, just the product name can be used.');
    }
}
