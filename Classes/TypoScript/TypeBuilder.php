<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\TypoScript;

use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Type\TypeFactory;
use DomainException;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Creates new Type from given TypoScript configuration.
 * @internal
 */
final class TypeBuilder
{
    private ContentObjectRenderer $cObj;

    public function __construct(
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * @param mixed[] $configuration
     */
    public function build(
        ContentObjectRenderer $cObj,
        array $configuration,
    ): ?TypeInterface {
        $this->cObj = $cObj;

        if ($this->hasFalsyIf($configuration)) {
            return null;
        }
        unset($configuration['if.']);

        $type = $this->instantiateType($configuration);
        if (! $type instanceof TypeInterface) {
            return null;
        }

        $type->setId((string)$this->cObj->stdWrapValue('id', $configuration));

        return $type;
    }

    /**
     * @param mixed[] $configuration
     */
    private function instantiateType(array $configuration): ?TypeInterface
    {
        $configuredType = (string)$this->cObj->stdWrapValue('type', $configuration);

        try {
            return TypeFactory::createType($configuredType);
        } catch (DomainException) {
            // Do not break production sites, catch exception and return nothing.
            $this->logger->error(\sprintf('Use of unknown type "%s"', $configuredType));
        }

        return null;
    }

    /**
     * @param mixed[] $configuration
     */
    private function hasFalsyIf(array $configuration): bool
    {
        return isset($configuration['if.'])
            && ! $this->cObj->checkIf($configuration['if.']);
    }
}
