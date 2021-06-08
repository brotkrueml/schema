<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Fixtures\Model\Type;

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Core\Model\WebPageTypeInterface;

final class WebPage extends AbstractType implements WebPageTypeInterface
{
    /**
     * @var string[]
     */
    protected static $propertyNames = [
        'breadcrumb',
        'expires',
        'mainEntity',
    ];
}
