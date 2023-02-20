<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Manager;

use Brotkrueml\Schema\Adapter\ApplicationType;
use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Core\Model\WebPageTypeInterface;
use Brotkrueml\Schema\Event\InitialiseTypesEvent;
use Brotkrueml\Schema\Extension;
use Brotkrueml\Schema\JsonLd\RendererInterface;
use Brotkrueml\Schema\Model\Type\BreadcrumbList;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\SingletonInterface;

final class SchemaManager implements SingletonInterface
{
    private const WEBPAGE_PROPERTY_BREADCRUMB = 'breadcrumb';
    private const WEBPAGE_PROPERTY_MAIN_ENTITY = 'mainEntity';

    private readonly MainEntityOfWebPageBag $mainEntityOfWebPageBag;
    /**
     * @var TypeInterface[]
     */
    private array $types = [];
    private ?TypeInterface $webPage = null;
    /**
     * @var BreadcrumbList[]
     */
    private array $breadcrumbLists = [];

    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly ExtensionConfiguration $extensionConfiguration,
        private readonly RendererInterface $renderer,
        private readonly ApplicationType $applicationType,
    ) {
        $this->mainEntityOfWebPageBag = new MainEntityOfWebPageBag();

        if ($this->applicationType->isBackend()) {
            return;
        }

        /** @var InitialiseTypesEvent $event */
        $event = $this->eventDispatcher->dispatch(new InitialiseTypesEvent());
        \array_map(fn (TypeInterface $type): SchemaManager => $this->addType($type), $event->getTypes());
    }

    /**
     * Add a type
     *
     * @param TypeInterface $type The model type
     */
    public function addType(TypeInterface $type): self
    {
        if ($this->isWebPageType($type)) {
            $this->setWebPage($type);

            return $this;
        }

        if ($this->isBreadCrumbList($type)) {
            /** @var BreadcrumbList $type */
            $this->addBreadcrumbList($type);

            return $this;
        }

        $this->types[] = $type;

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
        if ($this->extensionConfiguration->get(Extension::KEY, 'allowOnlyOneBreadcrumbList')) {
            $this->breadcrumbLists = [$breadcrumbList];
            return;
        }

        $this->breadcrumbLists[] = $breadcrumbList;
    }

    /**
     * A WebPage or its descendants is available
     */
    public function hasWebPage(): bool
    {
        return $this->webPage !== null;
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
