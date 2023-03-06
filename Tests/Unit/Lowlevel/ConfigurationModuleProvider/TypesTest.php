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
use Brotkrueml\Schema\Type\TypeProvider;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @runInSeparateProcess
 */
final class TypesTest extends TestCase
{
    private TypeProvider $typeProvider;
    private Types $subject;

    protected function setUp(): void
    {
        $this->typeProvider = new TypeProvider();
        $this->subject = new Types($this->typeProvider);

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
        $languageServiceStub = $this->createStub(LanguageService::class);
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

    /**
     * @test
     */
    public function getIdentifierReturnsCorrectIdentifier(): void
    {
        $this->subject->__invoke([
            'identifier' => 'some-identifier',
        ]);

        self::assertSame('some-identifier', $this->subject->getIdentifier());
    }

    /**
     * @test
     */
    public function getLabelReturnsCorrectLabel(): void
    {
        self::assertSame('Some label', $this->subject->getLabel());
    }

    /**
     * @test
     */
    public function getConfigurationReturnsCorrectConfiguration(): void
    {
        $this->typeProvider->addType('ItemPage', FixtureType\ItemPage::class);
        $this->typeProvider->addType('Person', FixtureType\Person::class);
        $this->typeProvider->addType('Table', FixtureType\Table::class);
        $this->typeProvider->addType('Thing', FixtureType\Thing::class);
        $this->typeProvider->addType('WebPage', FixtureType\WebPage::class);

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
