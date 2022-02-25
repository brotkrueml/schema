<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Hooks;

use PHPUnit\Runner\BeforeTestHook;

final class ContentObjectsInitialisationHook implements BeforeTestHook
{
    public function executeBeforeTest(string $test): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['FE']['ContentObjects'] ??= [];
    }
}
