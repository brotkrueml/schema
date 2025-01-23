<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema;

use Brotkrueml\Schema\AdminPanel\SchemaModule;
use Brotkrueml\Schema\AdminPanel\TypesInformation;
use Brotkrueml\Schema\Cache\PagesCacheService;
use Brotkrueml\Schema\Configuration\Configuration;
use Brotkrueml\Schema\Configuration\ConfigurationProvider;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\DependencyInjection\TypeProviderPass;
use Brotkrueml\Schema\EventListener\AddBreadcrumbList;
use Brotkrueml\Schema\EventListener\AddWebPageType;
use Brotkrueml\Schema\EventListener\RegisterRemovedTypePropertiesForPhysician;
use Brotkrueml\Schema\EventListener\RegisterTypePropertiesMovedFromOfficialToPending;
use Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection;
use Brotkrueml\Schema\JsonLd\Renderer;
use Brotkrueml\Schema\Lowlevel\ConfigurationModuleProvider\Types;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\TypoScript\SchemaContentObject;
use Brotkrueml\Schema\TypoScript\TypoScriptToSchema;
use Brotkrueml\Schema\UserFunctions\FormEngine\WebPageTypes;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $configurator, ContainerBuilder $builder): void {
    $builder->registerForAutoconfiguration(TypeInterface::class)->addTag('tx_schema.type');
    $builder->addCompilerPass(new TypeProviderPass('tx_schema.type'));

    $services = $configurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('Brotkrueml\Schema\\', __DIR__ . '/../Classes/*')
        ->exclude([
            __DIR__ . '/../Classes/Extension.php',
        ]);

    $services->set('schema.configuration', Configuration::class)
        ->factory([
            service(ConfigurationProvider::class),
            'getConfiguration',
        ]);

    $services->set(TypesInformation::class)
        ->public();

    $services->set(SchemaMarkupInjection::class)
        ->public()
        ->arg('$configuration', service('schema.configuration'));

    $services->set(Renderer::class)
        ->public();

    $services->set(SchemaManager::class)
        ->arg('$configuration', service('schema.configuration'));

    $services->set(TypoScriptToSchema::class)
        ->public();

    $services->set(PagesCacheService::class)
        ->public()
        ->arg('$cache', service('cache.pages'));

    $services->set(SchemaModule::class)
        ->public();

    $services->set(AddBreadcrumbList::class)
        ->arg('$configuration', service('schema.configuration'))
        ->tag('event.listener', [
            'identifier' => 'ext-schema/addBreadcrumbList',
        ]);

    $services->set(AddWebPageType::class)
        ->arg('$configuration', service('schema.configuration'))
        ->tag('event.listener', [
            'identifier' => 'ext-schema/addWebPageType',
        ]);

    $services->set(RegisterTypePropertiesMovedFromOfficialToPending::class)
        ->tag('event.listener', [
            'identifier' => 'ext-schema/registerTypePropertiesMovedFromOfficialToPending',
        ]);

    $services->set(RegisterRemovedTypePropertiesForPhysician::class)
        ->tag('event.listener', [
            'identifier' => 'ext-schema/registerRemovedTypePropertiesForPhysician',
        ]);

    $services->set(SchemaContentObject::class)
        ->tag('frontend.contentobject', [
            'identifier' => 'SCHEMA',
        ]);

    $services->set(WebPageTypes::class)
        ->public();

    $services->set('brotkrueml.schema.configuration.module.provider.types', Types::class)
        ->tag('lowlevel.configuration.module.provider', [
            'identifier' => 'ext-schema/types',
        ]);
};
