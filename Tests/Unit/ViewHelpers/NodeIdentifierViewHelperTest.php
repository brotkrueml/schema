<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Unit\ViewHelpers;

use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Tests\Fixtures\Model\Type as FixtureType;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use Brotkrueml\Schema\Type\TypeRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class NodeIdentifierViewHelperTest extends ViewHelperTestCase
{
    use SchemaCacheTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->defineCacheStubsWhichReturnEmptyEntry();

        $typeRegistryStub = $this->createStub(TypeRegistry::class);
        $map = [
            ['Person', FixtureType\Person::class],
        ];
        $typeRegistryStub
            ->method('resolveModelClassFromType')
            ->willReturnMap($map);

        GeneralUtility::setSingletonInstance(TypeRegistry::class, $typeRegistryStub);
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
        parent::tearDown();
    }

    /**
     * @test
     */
    public function viewHelperPrintsNodeIdentifiersCorrectly(): void
    {
        $actual = $this->renderTemplate('<schema:nodeIdentifier id="some-id"/>', []);

        self::assertSame('some-id', $actual);
    }

    /**
     * @test
     */
    public function usingVariablesAndThenAssignedToTypePropertiesBuildsSchemaCorrectly(): void
    {
        $template = <<<EOF
<f:variable name="identifier1" value="{schema:nodeIdentifier(id: 'https://example.org/#john-smith')}"/>
<f:variable name="identifier2" value="{schema:nodeIdentifier(id: 'https://example.org/#sarah-jane-smith')}"/>
<schema:type.person name="John Smith" -id="{identifier1}" knows="{identifier2}"/>
<schema:type.person name="Sarah Jane Smith" -id="{identifier2}" knows="{identifier1}"/>
EOF
;

        $this->renderTemplate($template, []);
        $actual = $this->schemaManager->renderJsonLd();

        $expected = '{"@context":"https://schema.org/","@graph":[{"@type":"Person","@id":"https://example.org/#john-smith","name":"John Smith","knows":{"@id":"https://example.org/#sarah-jane-smith"}},{"@type":"Person","@id":"https://example.org/#sarah-jane-smith","name":"Sarah Jane Smith","knows":{"@id":"https://example.org/#john-smith"}}]}';
        self::assertSame(\sprintf(Extension::JSONLD_TEMPLATE, $expected), $actual);
    }
}
