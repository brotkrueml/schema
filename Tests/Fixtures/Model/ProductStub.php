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

#[Type('ProductStub')]
class ProductStub extends GenericStub
{
    protected string $type = 'ProductStub';

    public function getType(): string
    {
        return 'ProductStub';
    }
}
