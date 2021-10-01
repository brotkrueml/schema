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
use Brotkrueml\Schema\Type\TypeRegistry;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @runInSeparateProcess
 */
final class TypesTest extends TestCase
{
    /**
     * @var TypeRegistry|Stub
     */
    private $typeRegistryStub;
    private Types $subject;

    protected function setUp(): void
    {
        $this->typeRegistryStub = $this->createStub(TypeRegistry::class);
        $this->subject = new Types($this->typeRegistryStub);

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
            [
                Extension::LANGUAGE_PATH_DEFAULT . ':lowlevel.configuration.webPageElementTypes',
                'Web page element types',
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
        $this->typeRegistryStub
            ->method('getTypes')
            ->willReturn([
                'A type',
                'X type',
                'C type',
                'E1 type',
                'E2 type',
            ]);
        $this->typeRegistryStub
            ->method('getWebPageTypes')
            ->willReturn([
                'A type',
                'E1 type',
            ]);
        $this->typeRegistryStub
            ->method('getWebPageElementTypes')
            ->willReturn([
                'C type',
                'X type',
            ]);

        $expected = [
            'All types' => [
                'A' => [
                    'A type',
                ],
                'C' => [
                    'C type',
                ],
                'E' => [
                    'E1 type',
                    'E2 type',
                ],
                'X' => [
                    'X type',
                ],
            ],
            'Web page types' => [
                'A type',
                'E1 type',
            ],
            'Web page element types' => [
                'C type',
                'X type',
            ],
        ];

        self::assertSame($expected, $this->subject->getConfiguration());
    }
}
