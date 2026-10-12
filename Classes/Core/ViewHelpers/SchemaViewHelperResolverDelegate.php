<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Core\ViewHelpers;

use Brotkrueml\Schema\Type\ModelClassNotFoundException;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\ViewHelperResolverDelegateInterface;

/**
 * @internal
 */
final readonly class SchemaViewHelperResolverDelegate implements ViewHelperResolverDelegateInterface
{
    /**
     * @param string $name ViewHelper name as written in the template, for example "type.person"
     * @return class-string<ViewHelperInterface>
     * @throws ModelClassNotFoundException
     */
    public function resolveViewHelperClassName(string $name): string
    {
        if (\str_starts_with($name, 'type.')) {
            return TypeViewHelper::class;
        }

        $explodedViewHelperName = \explode('.', $name);

        return \sprintf(
            '%s\%sViewHelper',
            $this->getNamespace(),
            \implode('\\', \array_map(ucfirst(...), $explodedViewHelperName)),
        );
    }

    public function getNamespace(): string
    {
        return 'Brotkrueml\Schema\ViewHelpers';
    }
}
