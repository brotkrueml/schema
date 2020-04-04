<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Context;

class Typo3Mode
{
    /** @var string */
    private $mode;

    public function __construct()
    {
        $this->mode = \defined('TYPO3_MODE') ? TYPO3_MODE : '';
    }

    public function isInBackendMode(): bool
    {
        return $this->mode === 'BE';
    }

    public function isInFrontendMode(): bool
    {
        return $this->mode === 'FE';
    }
}
