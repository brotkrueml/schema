<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Fixtures\Model;

class ProductStub extends GenericStub
{
    public function __construct()
    {
        parent::__construct(
            null,
            [
                'name' => null,
                'sku' => null,
            ],
            'ProductStub'
        );
    }
}
