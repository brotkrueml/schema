<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\EventListener;

use Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent;
use Brotkrueml\Schema\EventListener\EmbedMarkupDependingOnNoIndexPageField;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * @coversDefaultClass \Brotkrueml\Schema\EventListener\EmbedMarkupDependingOnNoIndexPageField
 */
class EmbedMarkupDependingOnNoIndexPageFieldTest extends TestCase
{
    private EmbedMarkupDependingOnNoIndexPageField $subject;

    protected function setUp(): void
    {
        $this->subject = new EmbedMarkupDependingOnNoIndexPageField();
    }

    /**
     * @test
     * @covers ::__invoke
     */
    public function seoExtensionIsNotInstalledThenMarkupShouldBeEmbedded(): void
    {
        $this->setSeoExtensionInstallationState(false);

        $event = new ShouldEmbedMarkupEvent([], true);
        $this->subject->__invoke($event);

        self::assertTrue($event->getEmbedMarkup());
    }

    /**
     * @test
     * @covers ::__invoke
     */
    public function seoExtensionIsInstalledAndNoIndexIsNotSetThenMarkupShouldBeEmbedded(): void
    {
        $this->setSeoExtensionInstallationState(true);

        $event = new ShouldEmbedMarkupEvent(['no_index' => 0], true);
        $this->subject->__invoke($event);

        self::assertTrue($event->getEmbedMarkup());
    }

    /**
     * @test
     * @covers ::__invoke
     */
    public function seoExtensionIsInstalledAndNoIndexIsSetThenMarkupShouldNotBeEmbedded(): void
    {
        $this->setSeoExtensionInstallationState(true);

        $event = new ShouldEmbedMarkupEvent(['no_index' => 1], true);
        $this->subject->__invoke($event);

        self::assertFalse($event->getEmbedMarkup());
    }

    protected function setSeoExtensionInstallationState(bool $state): void
    {
        /** @var MockObject|PackageManager $packageManagerMock */
        $packageManagerMock = $this->createMock(PackageManager::class);
        $packageManagerMock
            ->expects(self::once())
            ->method('isPackageActive')
            ->with('seo')
            ->willReturn($state);

        ExtensionManagementUtility::setPackageManager($packageManagerMock);
    }
}
