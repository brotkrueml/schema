<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Manager;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Core\Model\WebPageTypeInterface;
use Brotkrueml\Schema\Model\Type\BreadcrumbList;
use Brotkrueml\Schema\Model\Type\WebPage;
use TYPO3\CMS\Core\SingletonInterface;

final class SchemaManager implements SingletonInterface
{
    private const TAG_TEMPLATE = '<script type="application/ld+json">%s</script>';

    private const CONTEXT = 'http://schema.org';

    private const WEBPAGE_PROPERTY_BREADCRUMB = 'breadcrumb';
    private const WEBPAGE_PROPERTY_MAIN_ENTITY = 'mainEntity';

    /** @var AbstractType[] */
    private $types = [];

    /** @var WebPage|null */
    private $webPage = null;

    /** @var BreadcrumbList[] */
    private $breadcrumbList = [];

    /** @var AbstractType|null */
    private $mainEntityOfWebPage = null;

    /**
     * Add a type
     *
     * @param AbstractType $type The model type
     * @return SchemaManager
     */
    public function addType(AbstractType $type): self
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

    private function isWebPageType(AbstractType $type): bool
    {
        return $type instanceof WebPageTypeInterface;
    }

    private function setWebPage(AbstractType $webPage): void
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

        if ($mainEntity instanceof AbstractType) {
            $this->setMainEntityOfWebPage($mainEntity);
        }

        $this->webPage = $webPage;
    }

    private function isBreadCrumbList(AbstractType $type): bool
    {
        return $type instanceof BreadcrumbList;
    }

    private function addBreadcrumbList(BreadcrumbList $breadcrumbList): void
    {
        $this->breadcrumbList[] = $breadcrumbList;
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
     * Set the main entity of the WebPage
     *
     * @param AbstractType $mainEntity
     * @return SchemaManager
     */
    public function setMainEntityOfWebPage(AbstractType $mainEntity): self
    {
        if ($this->mainEntityOfWebPage) {
            $this->addType($this->mainEntityOfWebPage);
        }

        $this->mainEntityOfWebPage = $mainEntity;

        return $this;
    }

    /**
     * Render the JSON-LD from the assigned types
     *
     * @return string
     */
    public function renderJsonLd(): string
    {
        $result = [];

        if ($this->webPage instanceof AbstractType) {
            $this->preparePropertiesForWebPage();
            $result[] = $this->webPage->toArray();
        } else {
            foreach ($this->breadcrumbList as $breadcrumb) {
                $result[] = $breadcrumb->toArray();
            }

            if ($this->mainEntityOfWebPage) {
                $result[] = $this->mainEntityOfWebPage->toArray();
            }
        }

        foreach ($this->types as $type) {
            $result[] = $type->toArray();
        }

        if (empty($result)) {
            return '';
        }

        if (\count($result) === 1) {
            $result = $result[0];
        } else {
            $result = ['@graph' => $result];
        }

        $result = \array_merge(['@context' => static::CONTEXT], $result);

        return \sprintf(
            static::TAG_TEMPLATE,
            \json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );
    }

    private function preparePropertiesForWebPage(): void
    {
        if (\count($this->breadcrumbList)) {
            $this->webPage->clearProperty(static::WEBPAGE_PROPERTY_BREADCRUMB);

            foreach ($this->breadcrumbList as $breadcrumb) {
                $this->webPage->addProperty(static::WEBPAGE_PROPERTY_BREADCRUMB, $breadcrumb);
            }
        }

        if ($this->mainEntityOfWebPage) {
            $this->webPage->addProperty(static::WEBPAGE_PROPERTY_MAIN_ENTITY, $this->mainEntityOfWebPage);
        }
    }
}
