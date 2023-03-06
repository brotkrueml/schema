<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Helper;

use Brotkrueml\Schema\Tests\Fixtures\Model\GenericStub;
use Brotkrueml\Schema\Tests\Fixtures\Model\ProductStub;
use Brotkrueml\Schema\Tests\Fixtures\Model\ServiceStub;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type as FixtureType;
use Brotkrueml\Schema\Type\TypeProvider;

trait TypeProviderWithFixturesTrait
{
    public function getTypeProvider(): TypeProvider
    {
        $typeProvider = new TypeProvider();
        $typeProvider->addType('3DModel', FixtureType\_3DModel::class);
        $typeProvider->addType('BreadcrumbList', FixtureType\BreadcrumbList::class);
        $typeProvider->addType('Image', FixtureType\Image::class);
        $typeProvider->addType('ItemPage', FixtureType\ItemPage::class);
        $typeProvider->addType('ListItem', FixtureType\ListItem::class);
        $typeProvider->addType('Person', FixtureType\Person::class);
        $typeProvider->addType('Table', FixtureType\Table::class);
        $typeProvider->addType('Thing', FixtureType\Thing::class);
        $typeProvider->addType('VideoGallery', FixtureType\VideoGallery::class);
        $typeProvider->addType('WebPage', FixtureType\WebPage::class);
        $typeProvider->addType('WebSite', FixtureType\WebSite::class);

        $typeProvider->addType('GenericStub', GenericStub::class);
        $typeProvider->addType('ProductStub', ProductStub::class);
        $typeProvider->addType('ServiceStub', ServiceStub::class);

        return $typeProvider;
    }
}
