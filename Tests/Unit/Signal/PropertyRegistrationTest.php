<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Tests\Unit\Signal;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Signal\PropertyRegistration;
use PHPUnit\Framework\TestCase;

class PropertyRegistrationTest extends TestCase
{
    /**
     * @var PropertyRegistration
     */
    private $propertyRegistration;

    public function setUp(): void
    {
        $this->propertyRegistration = new PropertyRegistration();
    }

    /**
     * @test
     *
     * @covers \Brotkrueml\Schema\Signal\PropertyRegistration::addPropertyForType
     * @covers \Brotkrueml\Schema\Signal\PropertyRegistration::getPropertiesForType
     */
    public function addPropertyForTypeStoresPropertiesCorrectly(): void
    {
        $this->propertyRegistration
            ->addPropertyForType('Thing', 'thingProperty1')
            ->addPropertyForType('Thing', 'thingProperty2')
            ->addPropertyForType('Person', 'personProperty1')
            ->addPropertyForType('Person', 'personProperty1')
        ;

        $actual = $this->propertyRegistration->getPropertiesForType('Thing');
        $this->assertSame(['thingProperty1', 'thingProperty2'], $actual, 'All different properties are correctly assigned');

        $actual = $this->propertyRegistration->getPropertiesForType('Person');
        $this->assertSame(['personProperty1'], $actual, 'Assigned the same property twice stores the property only once');

        $actual = $this->propertyRegistration->getPropertiesForType('Organization');
        $this->assertSame([], $actual, 'Not extended type has no additional properties');
    }
}
