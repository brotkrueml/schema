<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperResolverDelegateInterface;

/**
 * @internal
 */
final readonly class SchemaViewHelperResolverDelegate implements ViewHelperResolverDelegateInterface
{
    public function resolveViewHelperClassName(string $name): string
    {
        if (\str_starts_with($name, 'type.')) {
            return TypeViewHelper::class;
        }

        $explodedViewHelperName = \explode('.', $name);

        /** @var class-string $class */
        $class = \sprintf(
            '%s\%sViewHelper',
            $this->getNamespace(),
            \implode('\\', \array_map(ucfirst(...), $explodedViewHelperName)),
        );

        return $class;
    }

    public function getNamespace(): string
    {
        return 'Brotkrueml\Schema\ViewHelpers';
    }
}
