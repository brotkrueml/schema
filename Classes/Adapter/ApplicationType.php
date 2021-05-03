<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Adapter;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\ApplicationType as CoreApplicationType;

class ApplicationType
{
    private ?CoreApplicationType $applicationType = null;

    public function isBackend(): bool
    {
        if ($this->applicationType === null) {
            $this->applicationType = CoreApplicationType::fromRequest($this->getRequest());
        }

        return $this->applicationType->isBackend();
    }

    private function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }
}
