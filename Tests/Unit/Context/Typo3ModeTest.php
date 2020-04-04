<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Unit\Context;

use Brotkrueml\Schema\Context\Typo3Mode;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 * @coversDefaultClass \Brotkrueml\Schema\Context\Typo3Mode
 */
class Typo3ModeTest extends TestCase
{
    /**
     * @test
     * @covers ::isInBackendMode
     */
    public function isInBackendModeReturnsFalseWhenConstantIsNotDefined(): void
    {
        $subject = new Typo3Mode();

        self::assertFalse($subject->isInBackendMode());
    }

    /**
     * @test
     * @covers ::isInBackendMode
     */
    public function isInBackendModeReturnsFalseWhenConstantIsSetToFE(): void
    {
        \define('TYPO3_MODE', 'FE');

        $subject = new Typo3Mode();

        self::assertFalse($subject->isInBackendMode());
    }

    /**
     * @test
     * @covers ::isInBackendMode
     */
    public function isInBackendModeReturnsTrueWhenConstantIsSetToBE(): void
    {
        \define('TYPO3_MODE', 'BE');

        $subject = new Typo3Mode();

        self::assertTrue($subject->isInBackendMode());
    }

    /**
     * @test
     * @covers ::isInFrontendMode
     */
    public function isInFrontendModeReturnsFalseWhenConstantIsNotDefined(): void
    {
        $subject = new Typo3Mode();

        self::assertFalse($subject->isInFrontendMode());
    }

    /**
     * @test
     * @covers ::isInFrontendMode
     */
    public function isInFrontendModeReturnsFalseWhenConstantIsSetToBE(): void
    {
        \define('TYPO3_MODE', 'BE');

        $subject = new Typo3Mode();

        self::assertFalse($subject->isInFrontendMode());
    }

    /**
     * @test
     * @covers ::isInFrontendMode
     */
    public function isInFrontendModeReturnsTrueWhenConstantIsSetToFE(): void
    {
        \define('TYPO3_MODE', 'FE');

        $subject = new Typo3Mode();

        self::assertTrue($subject->isInFrontendMode());
    }
}
