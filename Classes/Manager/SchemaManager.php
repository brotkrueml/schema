<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Manager;

use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Core\Model\WebPageTypeInterface;
use Brotkrueml\Schema\JsonLd\Renderer;
use Brotkrueml\Schema\JsonLd\RendererInterface;
use Brotkrueml\Schema\Model\Type\BreadcrumbList;
use TYPO3\CMS\Core\SingletonInterface;

final class SchemaManager implements SingletonInterface
{
    private const WEBPAGE_PROPERTY_BREADCRUMB = 'breadcrumb';
    private const WEBPAGE_PROPERTY_MAIN_ENTITY = 'mainEntity';

    /** @var RendererInterface */
    private $renderer;

    /** @var TypeInterface[] */
    private $types = [];

    /** @var WebPageTypeInterface|TypeInterface */
    private $webPage;

    /** @var BreadcrumbList[] */
    private $breadcrumbLists = [];

    /** @var TypeInterface[] */
    private $mainEntitiesOfWebPage = [];

    public function __construct(RendererInterface $renderer = null)
    {
        $this->renderer = $renderer ?? new Renderer();
    }

    /**
     * Add a type
     *
     * @param TypeInterface $type The model type
     * @return SchemaManager
     */
    public function addType(TypeInterface $type): self
    {
        if ($this->isWebPageType($type)) {
            $this->setWebPage($type);

            return $this;
        }

        if ($this->isBreadCrumbList($type)) {
            /**
             * @var BreadcrumbList $type
             * @psalm-suppress ArgumentTypeCoercion
             */
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
        $breadcrumb = $webPage->getProperty(static::WEBPAGE_PROPERTY_BREADCRUMB);
        $webPage->clearProperty(static::WEBPAGE_PROPERTY_BREADCRUMB);

        if ($breadcrumb instanceof BreadcrumbList) {
            $this->addBreadcrumbList($breadcrumb);
        } elseif (\is_array($breadcrumb)) {
            foreach ($breadcrumb as $item) {
                if ($item instanceof BreadcrumbList) {
                    $this->addBreadcrumbList($item);
                }
            }
        }

        $mainEntity = $webPage->getProperty(static::WEBPAGE_PROPERTY_MAIN_ENTITY);
        $webPage->clearProperty(static::WEBPAGE_PROPERTY_MAIN_ENTITY);

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
        $this->breadcrumbLists[] = $breadcrumbList;
    }

    /**
     * A WebPage or its descendants is available
     *
     * @return bool
     */
    public function hasWebPage(): bool
    {
        return $this->webPage !== null;
    }

    /**
     * Add a main entity of the WebPage
     *
     * @param TypeInterface $mainEntity
     * @return SchemaManager
     *
     * @deprecated since version 1.4.1, will be removed in version 2.0.0. Use SchemaManager->addMainEntityOfWebPage() instead.
     */
    public function setMainEntityOfWebPage(TypeInterface $mainEntity): self
    {
        \trigger_error(
            'Using SchemaManager->setMainEntityOfWebPage() is deprecated since version 1.4.1 and will be removed in version 2.0.0. Use SchemaManager->addMainEntityOfWebPage() instead.',
            \E_USER_DEPRECATED
        );

        return $this->addMainEntityOfWebPage($mainEntity);
    }

    /**
     * Add a main entity of the WebPage
     *
     * @param TypeInterface $mainEntity
     * @return SchemaManager
     */
    public function addMainEntityOfWebPage(TypeInterface $mainEntity): self
    {
        $this->mainEntitiesOfWebPage[] = $mainEntity;

        return $this;
    }

    /**
     * Render the JSON-LD from the assigned types
     *
     * @return string
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
            $this->renderer->addType(...$this->breadcrumbLists, ...$this->mainEntitiesOfWebPage);
        }

        $this->renderer->addType(...$this->types);

        return $this->renderer->render();
    }

    /** @psalm-suppress PossiblyUndefinedMethod */
    private function preparePropertiesForWebPage(): void
    {
        if (\count($this->breadcrumbLists)) {
            $this->webPage->clearProperty(static::WEBPAGE_PROPERTY_BREADCRUMB);

            foreach ($this->breadcrumbLists as $breadcrumb) {
                $this->webPage->addProperty(static::WEBPAGE_PROPERTY_BREADCRUMB, $breadcrumb);
            }
        }

        $numberOfMainEntities = \count($this->mainEntitiesOfWebPage);
        if ($numberOfMainEntities === 1) {
            $this->webPage->addProperty(static::WEBPAGE_PROPERTY_MAIN_ENTITY, $this->mainEntitiesOfWebPage[0]);
        } elseif ($numberOfMainEntities > 1) {
            $this->webPage->addProperty(static::WEBPAGE_PROPERTY_MAIN_ENTITY, $this->mainEntitiesOfWebPage);
        }
    }
}
