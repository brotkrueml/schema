<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\ViewHelpers;

use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Type\TypeFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;

/**
 * ViewHelper for building the breadcrumb structure and assigning it
 * to the SchemaManager
 *
 * The result of the MenuProcessor (special = breadcrumb) can be
 * given to the view helper:
 *
 * <code title="Configuring the MenuProcessor in TypoScript">
 * page.10 = FLUIDTEMPLATE
 * page.10 {
 *   // ... Your other configuration
 *
 *   dataProcessing {
 *     10 = TYPO3\CMS\Frontend\DataProcessing\MenuProcessor
 *     10 {
 *       special = rootline
 *       as = breadcrumb
 *     }
 *   }
 * }
 * </code>
 *
 * As default the first entry (which is mostly the start page)
 * is stripped from the structured data because it is not necessary.
 * But you can include it setting the attribute renderFirstItem="1".
 *
 * = Examples =
 * <code title="Render structured data without the start page">
 * <schema:breadcrumbMarkup breadcrumb="{breadcrumb}">
 * </code>
 *
 * <code title="Render structured data with all items given">
 * <schema:breadcrumbMarkup breadcrumb="{breadcrumb}" renderFirstItem="1">
 * </code>
 */
final class BreadcrumbViewHelper extends AbstractViewHelper
{
    private const ARGUMENT_BREADCRUMB = 'breadcrumb';
    private const ARGUMENT_RENDER_FIRST_ITEM = 'renderFirstItem';
    private const DEFAULT_WEBPAGE_TYPE = 'WebPage';

    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument(
            self::ARGUMENT_BREADCRUMB,
            'array',
            'The breadcrumb generated by the MenuProcessor or an equivalent data structure',
            true,
        );

        $this->registerArgument(
            self::ARGUMENT_RENDER_FIRST_ITEM,
            'bool',
            'Take the first item into the breadcrumb, normally this is the home page which is omitted',
            false,
            false,
        );
    }

    public function render(): void
    {
        $shouldRenderFirstItem = (bool) ($this->arguments[self::ARGUMENT_RENDER_FIRST_ITEM] ?? false);
        if (! $shouldRenderFirstItem) {
            \array_shift($this->arguments[self::ARGUMENT_BREADCRUMB]);
        }

        if ($this->arguments[self::ARGUMENT_BREADCRUMB] === []) {
            return;
        }

        $this->checkBreadcrumbStructure($this->arguments[self::ARGUMENT_BREADCRUMB]);

        /** @var string $siteUrl */
        $siteUrl = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');

        $typeFactory = new TypeFactory();
        $breadcrumbList = $typeFactory->create('BreadcrumbList');
        $itemsCount = \count($this->arguments[self::ARGUMENT_BREADCRUMB]);
        for ($i = 0; $i < $itemsCount; $i++) {
            $id = (string) $this->arguments[self::ARGUMENT_BREADCRUMB][$i]['link'];
            if (! \str_contains($id, '://')) {
                $id = $siteUrl . \ltrim($id, '/');
            }

            $webPageTypeClass = self::DEFAULT_WEBPAGE_TYPE;
            /*
            // @see: https://github.com/brotkrueml/schema/issues/101
            if (\is_array($this->arguments[self::ARGUMENT_BREADCRUMB][$i]['data'] ?? false)
                && ($this->arguments[self::ARGUMENT_BREADCRUMB][$i]['data']['tx_schema_webpagetype'] ?? '') !== '') {
                $webPageTypeClass = $this->arguments[self::ARGUMENT_BREADCRUMB][$i]['data']['tx_schema_webpagetype'];
            }
            */
            $itemType = $typeFactory->create($webPageTypeClass);
            $itemType->setId($id);

            $item = $typeFactory->create('ListItem')->setProperties([
                'position' => $i + 1,
                'name' => $this->arguments[self::ARGUMENT_BREADCRUMB][$i]['title'],
                'item' => $itemType,
            ]);

            $breadcrumbList->addProperty('itemListElement', $item);
        }

        /** @var SchemaManager $schemaManager */
        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $schemaManager->addType($breadcrumbList);
    }

    /**
     * @param list<array{title?: string, link?: string}> $breadcrumb
     */
    private function checkBreadcrumbStructure(array $breadcrumb): void
    {
        foreach ($breadcrumb as $item) {
            if (! isset($item['title'])) {
                throw new Exception(
                    'An item in the given breadcrumb structure does not have the "title" key.',
                    1561890280,
                );
            }

            if (! isset($item['link'])) {
                throw new Exception(
                    'An item in the given breadcrumb structure does not have the "link" key.',
                    1561890281,
                );
            }
        }
    }
}
