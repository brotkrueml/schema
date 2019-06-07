<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Hook\PageRenderer;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Manager\SchemaManager;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PostProcessHook
{
    /**
     * @param array $params
     * @param PageRenderer $pageRenderer
     */
    public function execute(/** @noinspection PhpUnusedParameterInspection */ ?array &$params, PageRenderer &$pageRenderer): void
    {
        if (TYPO3_MODE !== 'FE') {
            return;
        }

        /** @var SchemaManager $schemaManager */
        $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
        $result = $schemaManager->renderJsonLd();

        if ($result) {
            $pageRenderer->addHeaderData($result);
        }
    }
}
