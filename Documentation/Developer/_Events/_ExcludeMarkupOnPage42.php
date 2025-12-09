<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use Brotkrueml\Schema\Event\IsMarkupToBeInjectedEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\Page\PageInformation;

#[AsEventListener(
    identifier: 'my-extension/exclude-markup-from-page-42',
)]
final readonly class ExcludeMarkupOnPage42
{
    public function __invoke(IsMarkupToBeInjectedEvent $event): void
    {
        /** @var PageInformation $pageInformation */
        $pageInformation = $event->getRequest()->getAttribute('frontend.page.information');
        if ($pageInformation->getId() === 42) {
            $event->excludeMarkupFromInjection();
        }
    }
}
