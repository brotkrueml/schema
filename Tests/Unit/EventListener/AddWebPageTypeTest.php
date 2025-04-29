<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\EventListener;

use Brotkrueml\Schema\Configuration\Configuration;
use Brotkrueml\Schema\Event\RenderAdditionalTypesEvent;
use Brotkrueml\Schema\EventListener\AddWebPageType;
use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type as FixtureType;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use Brotkrueml\Schema\Tests\Helper\TypeProviderWithFixturesTrait;
use Brotkrueml\Schema\Type\TypeFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Frontend\Page\PageInformation;

#[CoversClass(AddWebPageType::class)]
final class AddWebPageTypeTest extends TestCase
{
    use SchemaCacheTrait;
    use TypeProviderWithFixturesTrait;

    private ExtensionConfiguration&Stub $extensionConfigurationStub;
    private PageInformation $pageInformation;
    private RenderAdditionalTypesEvent $event;
    private ServerRequestInterface&Stub $requestStub;

    protected function setUp(): void
    {
        $this->defineCacheStubsWhichReturnEmptyEntry();

        $this->extensionConfigurationStub = self::createStub(ExtensionConfiguration::class);

        $this->pageInformation = new PageInformation();
        $this->requestStub = self::createStub(ServerRequestInterface::class);
        $this->requestStub
            ->method('getAttribute')
            ->with('frontend.page.information')
            ->willReturn($this->pageInformation);

        $this->event = new RenderAdditionalTypesEvent(false, false, $this->requestStub);
    }

    #[Test]
    public function noWebPageTypeIsAddedWhenItShouldNotBeGeneratedViaConfiguration(): void
    {
        $configuration = $this->buildConfiguration(false);

        $subject = new AddWebPageType($configuration, new TypeFactory($this->getTypeProvider()));

        $this->extensionConfigurationStub
            ->method('get')
            ->with(Extension::KEY, 'automaticWebPageSchemaGeneration')
            ->willReturn(false);

        $subject->__invoke($this->event);

        self::assertSame([], $this->event->getAdditionalTypes());
    }

    #[Test]
    public function noWebPageTypeIsAddedWhenItIsAlreadyDefined(): void
    {
        $configuration = $this->buildConfiguration(true);

        $subject = new AddWebPageType($configuration, new TypeFactory($this->getTypeProvider()));

        $event = new RenderAdditionalTypesEvent(true, false, $this->requestStub);
        $subject->__invoke($event);

        self::assertSame([], $event->getAdditionalTypes());
    }

    #[Test]
    public function webPageTypeWebPageIsAddedWhenNoTypeIsDefinedInPageProperties(): void
    {
        $configuration = $this->buildConfiguration(true);

        $this->pageInformation->setPageRecord([
            'uid' => 1,
            'tx_schema_webpagetype' => '',
        ]);

        $subject = new AddWebPageType($configuration, new TypeFactory($this->getTypeProvider()));

        $subject->__invoke($this->event);

        self::assertCount(1, $this->event->getAdditionalTypes());
        self::assertInstanceOf(FixtureType\WebPage::class, $this->event->getAdditionalTypes()[0]);
        self::assertNull($this->event->getAdditionalTypes()[0]->getProperty('expires'));
    }

    #[Test]
    public function webPageTypeItemPageIsAddedWhenItemPageIsDefinedInPageProperties(): void
    {
        $configuration = $this->buildConfiguration(true);

        $subject = new AddWebPageType($configuration, new TypeFactory($this->getTypeProvider()));

        $this->pageInformation->setPageRecord([
            'uid' => 1,
            'tx_schema_webpagetype' => 'ItemPage',
        ]);

        $subject->__invoke($this->event);

        self::assertCount(1, $this->event->getAdditionalTypes());
        self::assertInstanceOf(FixtureType\ItemPage::class, $this->event->getAdditionalTypes()[0]);
    }

    #[Test]
    public function webPageTypeHasExpiresSetIfEndTimePagePropertiesIsDefined(): void
    {
        $configuration = $this->buildConfiguration(true);

        $subject = new AddWebPageType($configuration, new TypeFactory($this->getTypeProvider()));

        $this->pageInformation->setPageRecord([
            'uid' => 1,
            'endtime' => 1621615961,
            'tx_schema_webpagetype' => 'WebPage',
        ]);

        $subject->__invoke($this->event);

        self::assertCount(1, $this->event->getAdditionalTypes());
        self::assertInstanceOf(FixtureType\WebPage::class, $this->event->getAdditionalTypes()[0]);
        self::assertSame('2021-05-21T16:52:41+00:00', $this->event->getAdditionalTypes()[0]->getProperty('expires'));
    }

    private function buildConfiguration(bool $automaticWebPageSchemaGeneration): Configuration
    {
        return new Configuration(
            $automaticWebPageSchemaGeneration,
            false,
            [],
            false,
            false,
            false,
        );
    }
}
