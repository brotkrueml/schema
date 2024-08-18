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
use Brotkrueml\Schema\Type\TypeProvider;
use Brotkrueml\Schema\UserFunctions\FormEngine\WebPageTypes;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Information\Typo3Version;

#[CoversClass(WebPageTypes::class)]
final class WebPageTypesTest extends TestCase
{
    #[Test]
    public function getAddsWebPageTypesToItemsArrayForTypo3V11(): void
    {
        if ((new Typo3Version())->getMajorVersion() >= 12) {
            self::markTestSkipped();
        }

        $typeProvider = new TypeProvider();
        $typeProvider->addType('Thing', FixtureType\Thing::class);
        $typeProvider->addType('WebPage', FixtureType\WebPage::class);
        $typeProvider->addType('VideoGallery', FixtureType\VideoGallery::class);

        $subject = new WebPageTypes($typeProvider);

        $params = [
            'items' => [],
        ];
        $subject->get($params);

        self::assertCount(2, $params['items']);
        self::assertSame(['VideoGallery', 'VideoGallery'], $params['items'][0]);
        self::assertSame(['WebPage', 'WebPage'], $params['items'][1]);
    }

    #[Test]
    public function getAddsWebPageTypesToItemsArray(): void
    {
        if ((new Typo3Version())->getMajorVersion() < 12) {
            self::markTestSkipped();
        }

        $typeProvider = new TypeProvider();
        $typeProvider->addType('Thing', FixtureType\Thing::class);
        $typeProvider->addType('WebPage', FixtureType\WebPage::class);
        $typeProvider->addType('VideoGallery', FixtureType\VideoGallery::class);

        $subject = new WebPageTypes($typeProvider);

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
        $subject = new WebPageTypes(new TypeProvider());

        $params = [
            'items' => [],
        ];
        $subject->get($params);

        self::assertSame([], $params['items']);
    }
}
