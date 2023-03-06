<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\DependencyInjection;

use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Type\TypeProvider;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @internal
 */
final class TypeProviderPass implements CompilerPassInterface
{
    public function __construct(
        private readonly string $tagName,
    ) {
    }

    public function process(ContainerBuilder $container): void
    {
        if (! $container->hasDefinition(TypeProvider::class)) {
            return;
        }

        $typeProviderDefinition = $container->getDefinition(TypeProvider::class);

        foreach (\array_keys($container->findTaggedServiceIds($this->tagName)) as $serviceName) {
            /** @var class-string $serviceName */
            $reflector = new \ReflectionClass($serviceName);
            $attribute = $reflector->getAttributes(Type::class)[0] ?? null;

            if (! $attribute instanceof \ReflectionAttribute) {
                continue;
            }

            $typeProviderDefinition->addMethodCall('addType', [
                $attribute->getArguments()[0],
                $serviceName,
            ]);
        }
    }
}
