<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema;

use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\DependencyInjection\TypeProviderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator, ContainerBuilder $builder) {
    $builder->registerForAutoconfiguration(TypeInterface::class)->addTag('tx_schema.type');

    $builder->addCompilerPass(new TypeProviderPass('tx_schema.type'));
};
