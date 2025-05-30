<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\Lowlevel\ConfigurationModuleProvider;

use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Lowlevel\ConfigurationModuleProvider\Types;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type as FixtureType;
use Brotkrueml\Schema\Type\TypeRegistry;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

#[CoversClass(Types::class)]
#[RunTestsInSeparateProcesses]
final class TypesTest extends TestCase
{
    private TypeRegistry $typeRegistry;
    private Types $subject;

    protected function setUp(): void
    {
        $this->typeRegistry = new TypeRegistry();
        $this->subject = new Types($this->typeRegistry);

        $languageServiceMap = [
            [
                Extension::LANGUAGE_PATH_DEFAULT . ':lowlevel.configuration.label',
                'Some label',
            ],
            [
                Extension::LANGUAGE_PATH_DEFAULT . ':lowlevel.configuration.allTypes',
                'All types',
            ],
            [
                Extension::LANGUAGE_PATH_DEFAULT . ':lowlevel.configuration.webPageTypes',
                'Web page types',
            ],
        ];
        $languageServiceStub = self::createStub(LanguageService::class);
        $languageServiceStub
            ->method('sL')
            ->willReturnMap($languageServiceMap);
        $GLOBALS['LANG'] = $languageServiceStub;
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
        unset($GLOBALS['LANG']);
    }

    #[Test]
    public function getIdentifierReturnsCorrectIdentifier(): void
    {
        $this->subject->__invoke([
            'identifier' => 'some-identifier',
        ]);

        self::assertSame('some-identifier', $this->subject->getIdentifier());
    }

    #[Test]
    public function getLabelReturnsCorrectLabel(): void
    {
        self::assertSame('Some label', $this->subject->getLabel());
    }

    #[Test]
    public function getConfigurationReturnsCorrectConfiguration(): void
    {
        $this->typeRegistry->addType('ItemPage', FixtureType\ItemPage::class);
        $this->typeRegistry->addType('Person', FixtureType\Person::class);
        $this->typeRegistry->addType('Table', FixtureType\Table::class);
        $this->typeRegistry->addType('Thing', FixtureType\Thing::class);
        $this->typeRegistry->addType('WebPage', FixtureType\WebPage::class);

        $expected = [
            'All types' => [
                'I' => [
                    'ItemPage',
                ],
                'P' => [
                    'Person',
                ],
                'T' => [
                    'Table',
                    'Thing',
                ],
                'W' => [
                    'WebPage',
                ],
            ],
            'Web page types' => [
                'ItemPage',
                'WebPage',
            ],
        ];

        self::assertSame($expected, $this->subject->getConfiguration());
    }
}
