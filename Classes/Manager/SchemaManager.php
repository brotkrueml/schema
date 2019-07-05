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

    protected $validWebPageTypes;

    /** @var AbstractType[] */
    protected $types = [];

    /** @var WebPage|null */
    protected $webPage = null;

    /** @var BreadcrumbList[] */
    protected $breadcrumbList = [];

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
            $breadcrumb = $type->getProperty(static::WEBPAGE_PROPERTY_BREADCRUMB);
            $type->clearProperty(static::WEBPAGE_PROPERTY_BREADCRUMB);

            if ($breadcrumb instanceof BreadcrumbList) {
                $this->addBreadcrumbList($breadcrumb);
            } elseif (\is_array($breadcrumb)) {
                foreach ($breadcrumb as $item) {
                    if ($item instanceof BreadcrumbList) {
                        $this->addBreadcrumbList($item);
                    }
                }
            }

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

            $result[] = $this->webPage->toArray();
        } elseif (count($this->breadcrumbList)) {
            foreach ($this->breadcrumbList as $breadcrumb) {
                $result[] = $breadcrumb->toArray();
            }
        }

        foreach ($this->types as $type) {
            $array = $type->toArray();

            if (empty($array)) {
                continue;
            }

            $result[] = $array;
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
