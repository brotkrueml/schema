<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Helper;

use TYPO3\CMS\Core\Domain\Repository\PageRepository as CorePageRepository; // introduced in TYPO3 v10
use TYPO3\CMS\Frontend\Page\PageRepository as FrontendPageRepository; // deprecated in TYPO3 v10 and removed in TYPO3 v11

if (\class_exists(CorePageRepository::class)) {
    class PageRepository extends CorePageRepository
    {
    }
} else {
    class PageRepository extends FrontendPageRepository
    {
    }
}
