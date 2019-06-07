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
 * Computer programming source code. Example: Full (compile ready) solutions, code snippet samples, scripts, templates.
 *
 * schema.org version 3.6
 */
class SoftwareSourceCode extends CreativeWork
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('codeRepository', 'codeSampleType', 'programmingLanguage', 'runtimePlatform', 'targetProduct');
    }
}
