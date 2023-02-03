<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Helper;

use Psr\EventDispatcher\EventDispatcherInterface;

final class NoopEventDispatcher implements EventDispatcherInterface
{
    public function dispatch(object $event)
    {
        return $event;
    }
}
