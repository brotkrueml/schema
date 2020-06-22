<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\AdminPanel;

use Brotkrueml\Schema\Cache\PagesCacheService;
use Brotkrueml\Schema\Extension;
use TYPO3\CMS\Adminpanel\ModuleApi\AbstractModule;
use TYPO3\CMS\Adminpanel\ModuleApi\ShortInfoProviderInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @internal
 */
class SchemaModule extends AbstractModule implements ShortInfoProviderInterface
{
    /** @var PagesCacheService */
    private $pagesCacheService;

    /**
     * @psalm-suppress PropertyTypeCoercion
     */
    public function __construct(PagesCacheService $pagesCacheService = null)
    {
        $this->pagesCacheService = $pagesCacheService ?? GeneralUtility::makeInstance(PagesCacheService::class);

        parent::__construct();
    }

    public function getIconIdentifier(): string
    {
        return 'txschema-module-adminpanel';
    }

    /**
     * @inheritdoc
     */
    public function getIdentifier(): string
    {
        return 'ext-schema';
    }

    /**
     * @inheritdoc
     */
    public function getLabel(): string
    {
        return 'Schema';
    }

    /**
     * @inheritdoc
     */
    public function getShortInfo(): string
    {
        $jsonLd = $this->pagesCacheService->getMarkupFromCache();

        $numberOfTypes = 0;
        if (!empty($jsonLd)) {
            $jsonLd = \str_replace(['<script type="application/ld+json">', '</script>'], '', $jsonLd);
            $decodedJsonLd = \json_decode($jsonLd, true);
            $numberOfTypes = isset($decodedJsonLd['@graph']) ? \count($decodedJsonLd['@graph']) : 1;
        }

        return \sprintf(
            '(%s %s)',
            $numberOfTypes,
            $this->getLanguageService()->sL(
                Extension::LANGUAGE_PATH_DEFAULT . ':adminPanel.type' . ($numberOfTypes !== 1 ? 's' : '')
            )
        );
    }
}
