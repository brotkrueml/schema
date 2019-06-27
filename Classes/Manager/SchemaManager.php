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
use Brotkrueml\Schema\Model\Type\WebPage;
use Brotkrueml\Schema\Provider\WebPageTypeProvider;
use Brotkrueml\Schema\Utility\Utility;
use TYPO3\CMS\Core\SingletonInterface;

class SchemaManager implements SingletonInterface
{
    protected const TEMPLATE_SCRIPT_TAG = '<script type="application/ld+json">%s</script>';

    protected $validWebPageTypes;

    /** @var AbstractType[] */
    protected $types = [];

    /** @var WebPage|null */
    protected $webPage = null;

    public function __construct()
    {
        $this->validWebPageTypes = WebPageTypeProvider::getTypes();
    }

    /**
     * Add a type
     *
     * @param AbstractType $type
     * @return SchemaManager
     */
    public function addType(AbstractType $type): self
    {
        if ($this->isWebPageType($type)) {
            $this->setWebPage($type);
        } else {
            $this->types[] = $type;
        }

        return $this;
    }

    protected function isWebPageType(AbstractType $type): bool
    {
        $typeName = Utility::getClassNameWithoutNamespace(\get_class($type));

        return \in_array($typeName, $this->validWebPageTypes);
    }

    /**
     * Set the model of a web page
     * Only one web page is possible!
     *
     * @param AbstractType $webPage
     * @return SchemaManager
     */
    public function setWebPage(AbstractType $webPage): self
    {
        if (!$this->isWebPageType($webPage)) {
            throw new \DomainException(\sprintf(
                'Type %s is not a valid web page type (possible types: %s)',
                Utility::getClassNameWithoutNamespace(\get_class($webPage)),
                \implode(', ', $this->validWebPageTypes)
            ));
        }

        $this->webPage = $webPage;

        return $this;
    }

    /**
     * Get the model of a web page
     *
     * @return AbstractType|null
     */
    public function getWebPage(): ?AbstractType
    {
        return $this->webPage;
    }

    /**
     * Is a model of a web page set?
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
            $result[] = $this->webPage->toArray();
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

    /**
     * Get all assigned types
     *
     * Only for testing purposes, don't rely on it
     *
     * @return AbstractType[]
     * @internal
     */
    public function getTypes(): array
    {
        return $this->types;
    }
}
