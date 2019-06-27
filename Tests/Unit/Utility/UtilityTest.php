<?php

namespace Brotkrueml\Schema\Tests\Unit\Utility;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Utility\Utility;
use PHPUnit\Framework\TestCase;

class UtilityTest extends TestCase
{
    /**
     * @test
     */
    public function getClassNameWithoutNamespaceReturnsCorrectResultWithGivenNamespacedClass()
    {
        $actual = Utility::getClassNameWithoutNamespace('\\This\\Is\\The\\Namespace\\ClassName');

        $this->assertSame('ClassName', $actual);
    }

    /**
     * @test
     */
    public function getClassNameWithoutNamespaceReturnsCorrectResultWithNoNamespacedClass()
    {
        $actual = Utility::getClassNameWithoutNamespace('ClassName');

        $this->assertSame('ClassName', $actual);
    }
}
