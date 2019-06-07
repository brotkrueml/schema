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
use TYPO3\CMS\Core\SingletonInterface;

class SchemaManager implements SingletonInterface
{
    protected const TEMPLATE_SCRIPT_TAG = '<script type="application/ld+json">%s</script>';

    /**
     * @var AbstractType[]
     */
    protected $types = [];

    /**
     * Add a type
     *
     * @param AbstractType $type
     * @return SchemaManager
     */
    public function addType(AbstractType $type): self
    {
        $this->types[] = $type;

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
