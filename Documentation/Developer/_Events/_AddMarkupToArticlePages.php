<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use Brotkrueml\Schema\Event\RenderAdditionalTypesEvent;
use Brotkrueml\Schema\Type\TypeFactory;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\Page\PageInformation;

#[AsEventListener(
    identifier: 'my-extension/add-markup-to-article-pages',
)]
final readonly class AddMarkupToArticlePages
{
    public function __construct(
        private TypeFactory $typeFactory,
    ) {}

    public function __invoke(RenderAdditionalTypesEvent $event): void
    {
        // The "frontend.page.information" attribute is available since TYPO3 v13.
        // Use the "frontend.controller" attribute (TSFE) in older TYPO3 versions
        // to retrieve the page record.
        /** @var PageInformation $pageInformation */
        $pageInformation = $event->getRequest()->getAttribute('frontend.page.information');
        $page = $pageInformation->getPageRecord();
        if ($page['doktype'] !== 12345) {
            return;
        }

        // Only for doktype 12345
        $article = $this->typeFactory->create('Article');
        $article->setProperty('name', $page['title']);
        // ... and set some other properties

        $event->addType($article);
    }
}
