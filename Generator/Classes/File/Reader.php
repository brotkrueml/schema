<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Generator\File;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

class Reader
{
    /**
     * @var string
     */
    protected $filePath;

    public function __construct(string $filePath)
    {
        if (!\file_exists($filePath)) {
            throw new \InvalidArgumentException('File with path ' . $filePath . ' is not available');
        }

        $this->filePath = $filePath;
    }

    public function read(): string
    {
        return \file_get_contents($this->filePath);
    }
}
