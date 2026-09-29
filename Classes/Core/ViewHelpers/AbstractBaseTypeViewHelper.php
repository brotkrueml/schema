<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * @internal
 */
abstract class AbstractBaseTypeViewHelper extends AbstractViewHelper
{
    protected string $type = '';

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        foreach (NotableArgument::cases() as $argument) {
            $this->registerArgument(
                $argument->value,
                $argument->type(),
                $argument->description(),
                false,
                $argument->default(),
            );
        }
    }

    abstract protected function getType(): string;
}
