<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Caching;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Routing\PageArguments;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;
use TYPO3\CMS\Frontend\Page\CacheHashCalculator;

/**
 * @internal
 */
readonly class CacheIdentifierCreator
{
    public function __construct(
        private Context $context,
    ) {}

    /**
     * Inspired from PrepareTypoScriptFrontendRendering->createPageCacheIdentifier()
     */
    public function getCacheIdentifier(ServerRequestInterface $request): string
    {
        $pageInformation = $request->getAttribute('frontend.page.information');
        $pageId = $pageInformation->getId();
        /** @var PageArguments $pageArguments */
        $pageArguments = $request->getAttribute('routing');
        /** @var Site $site */
        $site = $request->getAttribute('site');
        /** @var SiteLanguage $language */
        $language = $request->getAttribute('language', $site->getDefaultLanguage());

        $dynamicArguments = [];
        $queryParams = $pageArguments->getDynamicArguments();
        if ($queryParams !== [] && \is_string(($pageArguments->getArguments()['cHash'] ?? false))) {
            $queryParams['id'] = $pageArguments->getPageId();
            $dynamicArguments = GeneralUtility::makeInstance(CacheHashCalculator::class)
                ->getRelevantParameters(HttpUtility::buildQueryString($queryParams));
        }

        $pageCacheIdentifierParameters = [
            'id' => $pageId,
            'type' => $pageArguments->getPageType(),
            'groupIds' => \implode(',', $this->context->getAspect('frontend.user')->getGroupIds()),
            'MP' => $pageInformation->getMountPoint(),
            'siteBase' => (string) $request->getAttribute('language', $site->getDefaultLanguage())->getBase(),
            'language' => $language->getLanguageId(),
            'staticRouteArguments' => $pageArguments->getStaticArguments(),
            'dynamicArguments' => $dynamicArguments,
        ];

        return $pageId . '_' . \hash('xxh3', \serialize($pageCacheIdentifierParameters));
    }
}
