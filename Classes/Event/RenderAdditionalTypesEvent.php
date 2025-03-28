<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Event;

use Brotkrueml\Schema\Core\Model\TypeInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @api since version 3.11.0
 */
final class RenderAdditionalTypesEvent
{
    /**
     * @var list<TypeInterface>
     */
    private array $types = [];

    public function __construct(
        private readonly bool $webPageTypeAlreadyDefined,
        private readonly bool $breadcrumbListAlreadyDefined,
        private readonly ServerRequestInterface $request,
    ) {}

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    public function addType(TypeInterface $type): void
    {
        $this->types[] = $type;
    }

    /**
     * @internal Not public API, only for internal use!
     */
    public function isWebPageTypeAlreadyDefined(): bool
    {
        return $this->webPageTypeAlreadyDefined;
    }

    /**
     * @internal Not public API, only for internal use!
     */
    public function isBreadcrumbListAlreadyDefined(): bool
    {
        return $this->breadcrumbListAlreadyDefined;
    }

    /**
     * @internal Not public API, only for internal use!
     * @return list<TypeInterface>
     */
    public function getAdditionalTypes(): array
    {
        return $this->types;
    }
}
