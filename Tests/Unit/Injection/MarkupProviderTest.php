<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Injection;

use Brotkrueml\Schema\Adapter\ExtensionAvailability;
use Brotkrueml\Schema\Cache\MarkupCacheHandler;
use Brotkrueml\Schema\Configuration\Configuration;
use Brotkrueml\Schema\Injection\MarkupProvider;
use Brotkrueml\Schema\Manager\SchemaManager;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\EventDispatcher\NoopEventDispatcher;
use TYPO3\CMS\Frontend\Page\PageInformation;

#[CoversClass(MarkupProvider::class)]
final class MarkupProviderTest extends TestCase
{
    #[Test]
    public function getMarkupReturnsMarkupIfSeoExtensionIsNotAvailable(): void
    {
        $subject = $this->buildSubject(
            cachedMarkup: 'some markup',
        );

        $requestStub = self::createStub(ServerRequestInterface::class);

        $actual = $subject->getMarkup($requestStub);

        self::assertSame('some markup', $actual);
    }

    #[Test]
    public function getMarkupReturnsMarkupIfSeoExtensionIsAvailableAndNoIndexIsSetToFalse(): void
    {
        $subject = $this->buildSubject(
            isSeoAvailable: true,
            cachedMarkup: 'some markup',
        );

        $pageInformation = new PageInformation();
        $pageInformation->setPageRecord([
            'no_index' => '0',
        ]);
        $requestStub = self::createStub(ServerRequestInterface::class);
        $requestStub
            ->method('getAttribute')
            ->willReturnMap([
                ['frontend.page.information', $pageInformation],
            ]);

        $actual = $subject->getMarkup($requestStub);

        self::assertSame('some markup', $actual);
    }

    #[Test]
    public function getMarkupReturnsMarkupIfSeoExtensionIsAvailableAndNoIndexIsSetToTrueAndEmbedMarkupOnNoIndexPagesIsSetToTrue(): void
    {
        $subject = $this->buildSubject(
            isSeoAvailable: true,
            embedMarkupOnNoIndexPages: true,
            cachedMarkup: 'some markup',
        );

        $pageInformation = new PageInformation();
        $pageInformation->setPageRecord([
            'no_index' => '1',
        ]);
        $requestStub = self::createStub(ServerRequestInterface::class);
        $requestStub
            ->method('getAttribute')
            ->willReturnMap([
                ['frontend.page.information', $pageInformation],
            ]);

        $actual = $subject->getMarkup($requestStub);

        self::assertSame('some markup', $actual);
    }

    #[Test]
    public function getMarkupReturnsMarkupIfSeoExtensionIsAvailableAndNoIndexIsSetToTrueAndEmbedMarkupOnNoIndexPagesIsSetToFalse(): void
    {
        $subject = $this->buildSubject(
            isSeoAvailable: true,
            cachedMarkup: 'some markup',
        );

        $pageInformation = new PageInformation();
        $pageInformation->setPageRecord([
            'no_index' => '1',
        ]);
        $requestStub = self::createStub(ServerRequestInterface::class);
        $requestStub
            ->method('getAttribute')
            ->willReturnMap([
                ['frontend.page.information', $pageInformation],
            ]);

        $actual = $subject->getMarkup($requestStub);

        self::assertSame('', $actual);
    }

    #[Test]
    public function getMarkupReturnsFreshMarkupRenderedFromSchemaManager(): void
    {
        $subject = $this->buildSubject(
            renderedJsonLd: 'rendered markup',
        );

        $requestStub = self::createStub(ServerRequestInterface::class);
        $actual = $subject->getMarkup($requestStub);

        self::assertSame('rendered markup', $actual);
    }

    private function buildSubject(
        bool $isSeoAvailable = false,
        bool $embedMarkupOnNoIndexPages = false,
        ?string $cachedMarkup = null,
        string $renderedJsonLd = '',
    ): MarkupProvider {
        $configuration = new Configuration(
            true,
            true,
            [],
            false,
            $embedMarkupOnNoIndexPages,
        );
        $extensionAvailabilityStub = self::createStub(ExtensionAvailability::class);
        $extensionAvailabilityStub
            ->method('isSeoAvailable')
            ->willReturn($isSeoAvailable);
        $markupCacheHandlerStub = self::createStub(MarkupCacheHandler::class);
        $markupCacheHandlerStub
            ->method('getMarkup')
            ->willReturn($cachedMarkup);
        $schemaManagerStub = self::createStub(SchemaManager::class);
        $schemaManagerStub
            ->method('renderJsonLd')
            ->willReturn($renderedJsonLd);

        return new MarkupProvider(
            $configuration,
            new NoopEventDispatcher(),
            $extensionAvailabilityStub,
            $markupCacheHandlerStub,
            $schemaManagerStub,
        );
    }
}
