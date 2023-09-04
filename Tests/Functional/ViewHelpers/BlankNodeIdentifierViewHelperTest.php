<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Tests\Functional\ViewHelpers;

use Brotkrueml\Schema\Core\Model\BlankNodeIdentifier;
use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\Tests\Helper\SchemaCacheTrait;
use Brotkrueml\Schema\Tests\Helper\TypeProviderWithFixturesTrait;
use Brotkrueml\Schema\Type\TypeProvider;
use Brotkrueml\Schema\ViewHelpers\BlankNodeIdentifierViewHelper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use TYPO3\CMS\Core\Utility\GeneralUtility;

#[CoversClass(BlankNodeIdentifierViewHelper::class)]
final class BlankNodeIdentifierViewHelperTest extends ViewHelperTestCase
{
    use SchemaCacheTrait;
    use TypeProviderWithFixturesTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->defineCacheStubsWhichReturnEmptyEntry();

        GeneralUtility::setSingletonInstance(TypeProvider::class, $this->getTypeProvider());

        // For every test case reset the counter. In a test case itself the counter starts now with 1.
        new BlankNodeIdentifier(true);
    }

    protected function tearDown(): void
    {
        GeneralUtility::purgeInstances();
        parent::tearDown();
    }

    #[Test]
    public function viewHelperUsedOncePrintsBlankNodeIdentifierCorrectly(): void
    {
        $actual = $this->renderTemplate('<schema:blankNodeIdentifier/>', []);

        self::assertSame('_:b1', $actual);
    }

    #[Test]
    public function viewHelperUsedTwicePrintsBlankNodeIdentifiersCorrectly(): void
    {
        $actual = $this->renderTemplate('<schema:blankNodeIdentifier/> <schema:blankNodeIdentifier/>', []);

        self::assertSame('_:b1 _:b2', $actual);
    }

    #[Test]
    public function usingVariablesAndThenAssignedToTypePropertiesBuildsSchemaCorrectly(): void
    {
        $template = <<<EOF
<f:variable name="blankIdentifier1" value="{schema:blankNodeIdentifier()}"/>
<f:variable name="blankIdentifier2" value="{schema:blankNodeIdentifier()}"/>
<schema:type.person name="John Smith" -id="{blankIdentifier1}" knows="{blankIdentifier2}"/>
<schema:type.person name="Sarah Jane Smith" -id="{blankIdentifier2}" knows="{blankIdentifier1}"/>
EOF
        ;

        $this->renderTemplate($template, []);
        $actual = $this->schemaManager->renderJsonLd();

        $expected = '{"@context":"https://schema.org/","@graph":[{"@type":"Person","@id":"_:b1","name":"John Smith","knows":{"@id":"_:b2"}},{"@type":"Person","@id":"_:b2","name":"Sarah Jane Smith","knows":{"@id":"_:b1"}}]}';
        self::assertSame(\sprintf(Extension::JSONLD_TEMPLATE, $expected), $actual);
    }
}
