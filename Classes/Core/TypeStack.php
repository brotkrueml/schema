<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core;

use Brotkrueml\Schema\Core\Model\TypeInterface;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * @template-extends \SplStack<TypeInterface>
 */
final class TypeStack extends \SplStack implements SingletonInterface {}
