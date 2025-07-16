<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\DependencyInjection;

use Brotkrueml\Schema\Type\AdditionalPropertiesProvider;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @internal
 */
final readonly class AdditionalPropertiesPass implements CompilerPassInterface
{
    public function __construct(
        private string $tagName,
    ) {}

    public function process(ContainerBuilder $container): void
    {
        if (! $container->hasDefinition(AdditionalPropertiesProvider::class)) {
            return;
        }

        $providerDefinition = $container->getDefinition(AdditionalPropertiesProvider::class)->setPublic(true);
        foreach (\array_keys($container->findTaggedServiceIds($this->tagName)) as $id) {
            $providerDefinition->addMethodCall('add', [$id]);
        }
    }
}
