<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Caching;

use Psr\Http\Message\ServerRequestInterface;

readonly class AdminPanelCacheHandler
{
    public function __construct(
        private PersistentCacheHandler $persistentCacheHandler,
        private RuntimeCacheHandler $runtimeCacheHandler,
    ) {}

    public function getMarkup(ServerRequestInterface $request): string
    {
        $markup = $this->runtimeCacheHandler->getMarkup() ?? '';
        if ($markup === '') {
            // The markup might be empty if the admin panel has been opened in the current request:
            // The SchemaMarkupInjection hook is not executed and therefore the runtime cache not set.
            // We try to get the markup from the persisted cache instead.
            return $this->persistentCacheHandler->getMarkup($request) ?? '';
        }

        return $markup;
    }
}
