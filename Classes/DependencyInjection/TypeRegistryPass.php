<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\DependencyInjection;

use Brotkrueml\Schema\Attributes\Manual;
use Brotkrueml\Schema\Attributes\Type;
use Brotkrueml\Schema\Type\TypeRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @internal
 */
final readonly class TypeRegistryPass implements CompilerPassInterface
{
    public function __construct(
        private string $tagName,
    ) {}

    public function process(ContainerBuilder $container): void
    {
        if (! $container->hasDefinition(TypeRegistry::class)) {
            return;
        }

        $typeRegistryDefinition = $container->getDefinition(TypeRegistry::class);

        foreach (\array_keys($container->findTaggedServiceIds($this->tagName)) as $serviceName) {
            /** @var class-string $serviceName */
            $reflector = new \ReflectionClass($serviceName);

            $typeAttribute = $reflector->getAttributes(Type::class)[0] ?? null;
            if (! $typeAttribute instanceof \ReflectionAttribute) {
                continue;
            }
            $typeName = $typeAttribute->getArguments()[0];
            $typeRegistryDefinition->addMethodCall('addType', [
                $typeName,
                $serviceName,
            ]);

            $manualAttributes = $reflector->getAttributes(Manual::class);
            foreach ($manualAttributes as $manualAttribute) {
                $typeRegistryDefinition->addMethodCall('addManualForType', [
                    $typeName,
                    $manualAttribute->getArguments(),
                ]);
            }
        }
    }
}
