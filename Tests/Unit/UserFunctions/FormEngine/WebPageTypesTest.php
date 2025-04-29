<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\UserFunctions\FormEngine;

use Brotkrueml\Schema\Tests\Fixtures\Model\Type as FixtureType;
use Brotkrueml\Schema\Type\TypeRegistry;
use Brotkrueml\Schema\UserFunctions\FormEngine\WebPageTypes;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(WebPageTypes::class)]
final class WebPageTypesTest extends TestCase
{
    #[Test]
    public function getAddsWebPageTypesToItemsArray(): void
    {
        $typeRegistry = new TypeRegistry();
        $typeRegistry->addType('Thing', FixtureType\Thing::class);
        $typeRegistry->addType('WebPage', FixtureType\WebPage::class);
        $typeRegistry->addType('VideoGallery', FixtureType\VideoGallery::class);

        $subject = new WebPageTypes($typeRegistry);

        $params = [
            'items' => [],
        ];
        $subject->get($params);

        self::assertCount(2, $params['items']);
        self::assertSame([
            'label' => 'VideoGallery',
            'value' => 'VideoGallery',
        ], $params['items'][0]);
        self::assertSame([
            'label' => 'WebPage',
            'value' => 'WebPage',
        ], $params['items'][1]);
    }

    #[Test]
    public function getDoesNotAddWebPageTypesWhenNoWebPageTypesAreAvailable(): void
    {
        $subject = new WebPageTypes(new TypeRegistry());

        $params = [
            'items' => [],
        ];
        $subject->get($params);

        self::assertSame([], $params['items']);
    }
}
