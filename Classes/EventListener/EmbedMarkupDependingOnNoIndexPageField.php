<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\EventListener;

use Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class EmbedMarkupDependingOnNoIndexPageField
{
    public function __invoke(ShouldEmbedMarkupEvent $event): void
    {
        if (!ExtensionManagementUtility::isLoaded('seo')) {
            return;
        }

        if ($event->getPage()['no_index'] ?? false) {
            $event->setEmbedMarkup(false);
        }
    }
}
