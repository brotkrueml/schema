<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Tests\Fixtures\Model\Type\BreadcrumbList;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\Image;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\Table;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\Thing;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\WebPage;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type\WebSite;

return [
    WebPage::class,
    Image::class,
    BreadcrumbList::class,
    Thing::class,
    Table::class,
    WebSite::class,
];
