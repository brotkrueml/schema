<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Generator\File;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
class Writer
{
    /**
     * @var string
     */
    protected $template;

    /**
     * @var string
     */
    protected $outputPath;

    /**
     * @var string
     */
    protected $classSuffix;

    /**
     * @var array
     */
    protected $placeholders = [];


    public function __construct(string $templatePathAndFileName, string $outputPath, string $classSuffix = '')
    {
        if (!\file_exists($templatePathAndFileName)) {
            throw new \InvalidArgumentException('Template path ' . $templatePathAndFileName . ' not found!');
        }

        $template = file_get_contents($templatePathAndFileName);
        if ($template === false) {
            throw new \UnexpectedValueException('Could not read template path ' . $templatePathAndFileName . '!');
        };

        $outputPath = rtrim($outputPath, '/') . '/';

        if (!\file_exists($outputPath) && !\mkdir($outputPath, 0755, true)) {
            throw new \RuntimeException('Output path ' . $outputPath . ' could not be created!');
        }

        $this->template = $template;
        $this->outputPath = $outputPath;
        $this->classSuffix = $classSuffix;
    }

    public function setPlaceholders(array $placeholders): self
    {
        $this->placeholders = $placeholders;

        return $this;
    }

    public function write(string $fileName): void
    {
        $contentToWrite = \str_replace(\array_keys($this->placeholders), \array_values($this->placeholders),
            $this->template);

        $outputFile = $this->outputPath . $fileName . $this->classSuffix . '.php';

        if (\file_put_contents($outputFile, $contentToWrite) === false) {
            throw new \RuntimeException('Could not write ' . $outputFile);
        }
    }
}
