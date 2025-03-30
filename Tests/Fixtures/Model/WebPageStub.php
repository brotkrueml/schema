<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Fixtures\Model;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Core\Model\WebPageTypeInterface;

#[Type('ProductStub')]
class WebPageStub extends GenericStub implements WebPageTypeInterface
{
    public function __construct()
    {
        parent::__construct(
            null,
            [
                'breadcrumb' => null,
                'mainEntity' => null,
            ],
            'WebPageStub',
        );
    }
}
