<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Configuration\Configuration;
use Brotkrueml\Schema\Configuration\ConfigurationProvider;
use Brotkrueml\Schema\Core\AdditionalPropertiesInterface;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\DependencyInjection\AdditionalPropertiesPass;
use Brotkrueml\Schema\DependencyInjection\TypeRegistryPass;
use Brotkrueml\Schema\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use TYPO3\CMS\Adminpanel\Service\ConfigurationService as AdminPanelConfigurationService;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $configurator, ContainerBuilder $builder): void {
    $builder->registerForAutoconfiguration(TypeInterface::class)->addTag('tx_schema.type');
    $builder->addCompilerPass(new TypeRegistryPass('tx_schema.type'));

    $builder->registerForAutoconfiguration(AdditionalPropertiesInterface::class)->addTag('tx_schema.additional_properties');
    $builder->addCompilerPass(new AdditionalPropertiesPass('tx_schema.additional_properties'));

    $services = $configurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $excludes = [
        __DIR__ . '/../Classes/Extension.php',
        __DIR__ . '/../Classes/Core/Model/',
    ];
    if (! $builder->hasDefinition(AdminPanelConfigurationService::class)) {
        $excludes[] = __DIR__ . '/../Classes/AdminPanel';
    }

    $services->load('Brotkrueml\Schema\\', __DIR__ . '/../Classes/*')
        ->exclude($excludes);

    $services->set('tx_schema.configuration', Configuration::class)
        ->factory([
            service(ConfigurationProvider::class),
            'getConfiguration',
        ]);

    $services->set(Extension::CACHE_MARKUP_SERVICE_ID, FrontendInterface::class)
        ->factory([
            service(CacheManager::class),
            'getCache',
        ])
        ->arg('$identifier', Extension::CACHE_IDENTIFIER);
};
