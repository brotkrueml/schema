<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Provider;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

final class WebPageTypeProvider
{
    public static function getTypesForTcaSelect(): array
    {
        return [
            ['', ''],
            ['AboutPage', 'AboutPage'],
            ['CheckoutPage', 'CheckoutPage'],
            ['CollectionPage', 'CollectionPage'],
            ['ContactPage', 'ContactPage'],
            ['FAQPage', 'FAQPage'],
            ['ImageGallery', 'ImageGallery'],
            ['ItemPage', 'ItemPage'],
            ['ProfilePage', 'ProfilePage'],
            ['QAPage', 'QAPage'],
            ['SearchResultsPage', 'SearchResultsPage'],
            ['VideoGallery', 'VideoGallery'],
            ['WebPage', 'WebPage'],
        ];
    }
}
