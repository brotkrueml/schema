<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Manager;

use Brotkrueml\Schema\Configuration\Configuration;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Core\Model\WebPageTypeInterface;
use Brotkrueml\Schema\JsonLd\RendererInterface;
use Brotkrueml\Schema\Model\Type\BreadcrumbList;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class SchemaManager
{
    private const WEBPAGE_PROPERTY_BREADCRUMB = 'breadcrumb';
    private const WEBPAGE_PROPERTY_MAIN_ENTITY = 'mainEntity';

    private readonly MainEntityOfWebPageBag $mainEntityOfWebPageBag;
    /**
     * @var list<TypeInterface>
     */
    private array $types = [];
    private ?TypeInterface $webPage = null;
    /**
     * @var list<BreadcrumbList>
     */
    private array $breadcrumbLists = [];

    public function __construct(
        #[Autowire(service: 'tx_schema.configuration')]
        private readonly Configuration $configuration,
        private readonly RendererInterface $renderer,
    ) {
        $this->mainEntityOfWebPageBag = new MainEntityOfWebPageBag();
    }

    /**
     * Add a type
     *
     * @param TypeInterface ...$type The model types
     */
    public function addType(TypeInterface ...$type): self
    {
        foreach ($type as $singleType) {
            if ($this->isWebPageType($singleType)) {
                $this->setWebPage($singleType);
                continue;
            }

            if ($this->isBreadCrumbList($singleType)) {
                /** @var BreadcrumbList $singleType */
                $this->addBreadcrumbList($singleType);
                continue;
            }

            $this->types[] = $singleType;
        }

        return $this;
    }

    private function isWebPageType(TypeInterface $type): bool
    {
        return $type instanceof WebPageTypeInterface;
    }

    private function setWebPage(TypeInterface $webPage): void
    {
        $breadcrumb = $webPage->getProperty(self::WEBPAGE_PROPERTY_BREADCRUMB);
        $webPage->clearProperty(self::WEBPAGE_PROPERTY_BREADCRUMB);

        if ($breadcrumb instanceof BreadcrumbList) {
            $this->addBreadcrumbList($breadcrumb);
        } elseif (\is_array($breadcrumb)) {
            foreach ($breadcrumb as $item) {
                if ($item instanceof BreadcrumbList) {
                    $this->addBreadcrumbList($item);
                }
            }
        }

        $mainEntity = $webPage->getProperty(self::WEBPAGE_PROPERTY_MAIN_ENTITY);
        $webPage->clearProperty(self::WEBPAGE_PROPERTY_MAIN_ENTITY);

        if ($mainEntity instanceof TypeInterface) {
            $this->addMainEntityOfWebPage($mainEntity);
        } elseif (\is_array($mainEntity)) {
            foreach ($mainEntity as $item) {
                if ($item instanceof TypeInterface) {
                    $this->addMainEntityOfWebPage($item);
                }
            }
        }

        $this->webPage = $webPage;
    }

    private function isBreadCrumbList(TypeInterface $type): bool
    {
        return $type instanceof BreadcrumbList;
    }

    private function addBreadcrumbList(BreadcrumbList $breadcrumbList): void
    {
        if ($this->configuration->allowOnlyOneBreadcrumbList) {
            $this->breadcrumbLists = [$breadcrumbList];
            return;
        }

        $this->breadcrumbLists[] = $breadcrumbList;
    }

    /**
     * A WebPage or its descendants is available
     *
     * @internal
     */
    public function hasWebPage(): bool
    {
        return $this->webPage instanceof TypeInterface;
    }

    /**
     * At least one breadcrumb list is available
     *
     * @internal
     */
    public function hasBreadcrumbList(): bool
    {
        return $this->breadcrumbLists !== [];
    }

    /**
     * Add a main entity of the WebPage
     */
    public function addMainEntityOfWebPage(TypeInterface $mainEntity, bool $isPrioritised = false): self
    {
        $notPrioritisedTypes = $this->mainEntityOfWebPageBag->add($mainEntity, $isPrioritised);
        foreach ($notPrioritisedTypes as $type) {
            $this->addType($type);
        }

        return $this;
    }

    /**
     * Render the JSON-LD from the assigned types
     *
     * @internal
     */
    public function renderJsonLd(): string
    {
        $this->renderer->clearTypes();

        if ($this->webPage instanceof TypeInterface) {
            $this->preparePropertiesForWebPage();
            $this->renderer->addType($this->webPage);
        } else {
            $this->renderer->addType(...$this->breadcrumbLists, ...$this->mainEntityOfWebPageBag->getTypes());
        }

        $this->renderer->addType(...$this->types);

        return $this->renderer->render();
    }

    /**
     * @phpstan-assert TypeInterface $this->webPage
     */
    private function preparePropertiesForWebPage(): void
    {
        if ($this->breadcrumbLists !== []) {
            $this->webPage->clearProperty(self::WEBPAGE_PROPERTY_BREADCRUMB);

            foreach ($this->breadcrumbLists as $breadcrumb) {
                $this->webPage->addProperty(self::WEBPAGE_PROPERTY_BREADCRUMB, $breadcrumb);
            }
        }

        $numberOfMainEntities = \count($this->mainEntityOfWebPageBag);
        if ($numberOfMainEntities === 1) {
            $this->webPage->addProperty(self::WEBPAGE_PROPERTY_MAIN_ENTITY, $this->mainEntityOfWebPageBag->getTypes()[0]);
        } elseif ($numberOfMainEntities > 1) {
            $this->webPage->addProperty(self::WEBPAGE_PROPERTY_MAIN_ENTITY, $this->mainEntityOfWebPageBag->getTypes());
        }
    }
}
