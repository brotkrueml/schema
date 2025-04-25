<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\ViewHelpers\Security;

use TYPO3\CMS\Core\Core\RequestId;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

if ((new Typo3Version())->getMajorVersion() >= 12) {
    final class NonceViewHelper extends AbstractViewHelper
    {
        public function __construct(
            private readonly RequestId $requestId,
        ) {}

        public function initializeArguments(): void
        {
            parent::initializeArguments();
        }

        public function render(): string
        {
            return $this->requestId->nonce->consume();
        }
    }
} else {
    final class NonceViewHelper extends AbstractViewHelper
    {
        public function render(): string
        {
            return '';
        }
    }
}
