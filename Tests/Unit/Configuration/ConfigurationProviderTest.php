<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Configuration;

use Brotkrueml\Schema\Configuration\ConfigurationProvider;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

#[CoversClass(ConfigurationProvider::class)]
final class ConfigurationProviderTest extends TestCase
{
    /**
     * @param array<string, string> $extensionConfiguration
     * @param array<string, bool|int[]> $expected
     */
    #[Test]
    #[DataProvider('providerForGetConfigurationWithDifferentExtensionConfigurations')]
    public function getConfigurationWithDifferentExtensionConfigurations(array $extensionConfiguration, array $expected): void
    {
        $extensionConfigurationStub = self::createStub(ExtensionConfiguration::class);
        $extensionConfigurationStub
            ->method('get')
            ->willReturnMap([
                ['schema', $extensionConfiguration],
            ]);

        $subject = new ConfigurationProvider($extensionConfigurationStub);

        $actual = $subject->getConfiguration();

        self::assertSame($expected['automaticWebPageSchemaGeneration'], $actual->automaticWebPageSchemaGeneration);
        self::assertSame($expected['automaticBreadcrumbSchemaGeneration'], $actual->automaticBreadcrumbSchemaGeneration);
        self::assertSame($expected['automaticBreadcrumbExcludeAdditionalDoktypes'], $actual->automaticBreadcrumbExcludeAdditionalDoktypes);
        self::assertSame($expected['allowOnlyOneBreadcrumbList'], $actual->allowOnlyOneBreadcrumbList);
        self::assertSame($expected['embedMarkupOnNoindexPages'], $actual->embedMarkupOnNoindexPages);
    }

    /**
     * @return \Iterator<array<array<string, array<string, mixed>>, mixed>>
     */
    public static function providerForGetConfigurationWithDifferentExtensionConfigurations(): iterable
    {
        yield 'with empty configuration' => [
            'extensionConfiguration' => [],
            'expected' => [
                'automaticWebPageSchemaGeneration' => true,
                'automaticBreadcrumbSchemaGeneration' => false,
                'automaticBreadcrumbExcludeAdditionalDoktypes' => [],
                'allowOnlyOneBreadcrumbList' => false,
                'embedMarkupOnNoindexPages' => true,
            ],
        ];

        yield 'all with false or empty string' => [
            'extensionConfiguration' => [
                'automaticWebPageSchemaGeneration' => '0',
                'automaticBreadcrumbSchemaGeneration' => '0',
                'automaticBreadcrumbExcludeAdditionalDoktypes' => '',
                'allowOnlyOneBreadcrumbList' => '0',
                'embedMarkupOnNoindexPages' => '0',
            ],
            'expected' => [
                'automaticWebPageSchemaGeneration' => false,
                'automaticBreadcrumbSchemaGeneration' => false,
                'automaticBreadcrumbExcludeAdditionalDoktypes' => [],
                'allowOnlyOneBreadcrumbList' => false,
                'embedMarkupOnNoindexPages' => false,
            ],
        ];

        yield 'all with true or non-empty string' => [
            'extensionConfiguration' => [
                'automaticWebPageSchemaGeneration' => '1',
                'automaticBreadcrumbSchemaGeneration' => '1',
                'automaticBreadcrumbExcludeAdditionalDoktypes' => ',42, , 123,987, ',
                'allowOnlyOneBreadcrumbList' => '1',
                'embedMarkupOnNoindexPages' => '1',
            ],
            'expected' => [
                'automaticWebPageSchemaGeneration' => true,
                'automaticBreadcrumbSchemaGeneration' => true,
                'automaticBreadcrumbExcludeAdditionalDoktypes' => [42, 123, 987],
                'allowOnlyOneBreadcrumbList' => true,
                'embedMarkupOnNoindexPages' => true,
            ],
        ];
    }
}
