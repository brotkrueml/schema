<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Manager;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Model\Type\BreadcrumbList;
use Brotkrueml\Schema\Model\Type\WebPage;
use Brotkrueml\Schema\Provider\WebPageTypeProvider;
use Brotkrueml\Schema\Utility\Utility;
use TYPO3\CMS\Core\SingletonInterface;

class SchemaManager implements SingletonInterface
{
    protected const TEMPLATE_SCRIPT_TAG = '<script type="application/ld+json">%s</script>';

    protected const WEBPAGE_PROPERTY_BREADCRUMB = 'breadcrumb';
    protected const WEBPAGE_PROPERTY_MAIN_ENTITY = 'mainEntity';

    protected $validWebPageTypes;

    /** @var AbstractType[] */
    protected $types = [];

    /** @var WebPage|null */
    protected $webPage = null;

    /** @var BreadcrumbList[] */
    protected $breadcrumbList = [];

    /** @var AbstractType|null */
    protected $mainEntityOfWebPage = null;

    public function __construct()
    {
        $this->validWebPageTypes = WebPageTypeProvider::getTypes();
    }

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

    protected function isWebPageType(AbstractType $type): bool
    {
        $typeName = Utility::getClassNameWithoutNamespace(\get_class($type));

        return \in_array($typeName, $this->validWebPageTypes);
    }

    protected function setWebPage(AbstractType $webPage): void
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

    protected function isBreadCrumbList(AbstractType $type): bool
    {
        return $type instanceof BreadcrumbList;
    }

    protected function addBreadcrumbList(BreadcrumbList $breadcrumbList): void
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
        return $this->webPage instanceof AbstractType;
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
            if (count($this->breadcrumbList)) {
                $this->webPage->clearProperty(static::WEBPAGE_PROPERTY_BREADCRUMB);

                foreach ($this->breadcrumbList as $breadcrumb) {
                    $this->webPage->addProperty(static::WEBPAGE_PROPERTY_BREADCRUMB, $breadcrumb);
                }
            }

            if ($this->mainEntityOfWebPage) {
                $this->webPage->addProperty(static::WEBPAGE_PROPERTY_MAIN_ENTITY, $this->mainEntityOfWebPage);
            }

            $result[] = $this->webPage->toArray();
        } else {
            if (count($this->breadcrumbList)) {
                foreach ($this->breadcrumbList as $breadcrumb) {
                    $result[] = $breadcrumb->toArray();
                }
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
        }

        return \sprintf(
            static::TEMPLATE_SCRIPT_TAG,
            \json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );
    }
}
