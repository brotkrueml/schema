<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional\Caching;

use Brotkrueml\Schema\Caching\RuntimeCacheHandler;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class RuntimeCacheHandlerTest extends FunctionalTestCase
{
    protected array $coreExtensionsToLoad = [
        'adminpanel',
    ];

    protected array $testExtensionsToLoad = [
        'brotkrueml/schema',
    ];

    private RuntimeCacheHandler $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->get(RuntimeCacheHandler::class);
    }

    #[Test]
    public function getMarkupWithoutPreviouslySetReturnsNull(): void
    {
        $actual = $this->subject->getMarkup();

        self::assertNull($actual);
    }

    #[Test]
    public function getMarkupWithPreviouslySetReturnsMarkupCorrectly(): void
    {
        $this->subject->setMarkup('some-markup');

        $actual = $this->subject->getMarkup();

        self::assertSame('some-markup', $actual);
    }
}
