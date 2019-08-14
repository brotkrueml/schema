<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Model\TypeTrait;

/**
 * Computer programming source code. Example: Full (compile ready) solutions, code snippet samples, scripts, templates.
 */
final class SoftwareSourceCode extends AbstractType
{
    use TypeTrait\CreativeWorkTrait;
    use TypeTrait\SoftwareSourceCodeTrait;
    use TypeTrait\ThingTrait;
}
