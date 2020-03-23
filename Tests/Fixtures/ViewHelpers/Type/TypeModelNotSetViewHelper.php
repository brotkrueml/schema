<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Fixtures\ViewHelpers\Type;

use Brotkrueml\Schema\Core\ViewHelpers\AbstractTypeViewHelper;

final class TypeModelNotSetViewHelper extends AbstractTypeViewHelper
{
    protected static $typeModel = '';
}
