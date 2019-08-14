<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelpers;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Model\Type\BreadcrumbList;
use Brotkrueml\Schema\Model\Type\ListItem;
use Brotkrueml\Schema\Model\Type\WebPage;
use Brotkrueml\Schema\Utility\Utility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper;

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
final class BreadcrumbViewHelper extends ViewHelper\AbstractViewHelper
{
    private const ARGUMENT_BREADCRUMB = 'breadcrumb';
    private const ARGUMENT_RENDER_FIRST_ITEM = 'renderFirstItem';

    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument(
            static::ARGUMENT_BREADCRUMB,
            'array',
            'The breadcrumb generated by the MenuProcessor or an equivalent data structure',
            true
        );

        $this->registerArgument(
            static::ARGUMENT_RENDER_FIRST_ITEM,
            'bool',
            'Take the first item into the breadcrumb, normally this is the home page which is omitted',
            false,
            false
        );
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        if ($arguments[static::ARGUMENT_RENDER_FIRST_ITEM] === false) {
            \array_shift($arguments[static::ARGUMENT_BREADCRUMB]);
        }

        if (empty($arguments[static::ARGUMENT_BREADCRUMB])) {
            return;
        }

        static::checkBreadcrumbStructure($arguments[static::ARGUMENT_BREADCRUMB]);

        $siteUrl = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');

        $breadcrumbList = (new BreadcrumbList());
        for ($i = 0; $i < count($arguments[static::ARGUMENT_BREADCRUMB]); $i++) {
            $webPageTypeClass = WebPage::class;
            if (static::hasWebPageType($arguments[static::ARGUMENT_BREADCRUMB][$i])) {
                $givenItemTypeClass = Utility::getNamespacedClassNameForType($arguments[static::ARGUMENT_BREADCRUMB][$i]['data']['tx_schema_webpagetype']);
                $webPageTypeClass = $givenItemTypeClass ?: $webPageTypeClass;
            }

            /** @var AbstractType $itemType */
            $itemType = new $webPageTypeClass();
            $itemType->setId($siteUrl . ltrim($arguments[static::ARGUMENT_BREADCRUMB][$i]['link'], '/'));

            $item = (new ListItem())->setProperties([
                'position' => $i + 1,
                'name' => $arguments[static::ARGUMENT_BREADCRUMB][$i]['title'],
                'item' => $itemType,
            ]);

            $breadcrumbList->addProperty('itemListElement', $item);
        }

        /** @var SchemaManager $schemaManager */
        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $schemaManager->addType($breadcrumbList);
    }

    private static function hasWebPageType(array $breadcrumbItem): bool
    {
        return isset($breadcrumbItem['data'])
            && \is_array($breadcrumbItem['data'])
            && isset($breadcrumbItem['data']['tx_schema_webpagetype']);
    }

    private static function checkBreadcrumbStructure($breadcrumb)
    {
        foreach ($breadcrumb as $item) {
            if (!isset($item['title'])) {
                throw new ViewHelper\Exception(
                    'An item in the given breadcrumb structure does not have the "title" key.',
                    1561890280
                );
            }

            if (!isset($item['link'])) {
                throw new ViewHelper\Exception(
                    'An item in the given breadcrumb structure does not have the "link" key.',
                    1561890281
                );
            }
        }
    }
}
