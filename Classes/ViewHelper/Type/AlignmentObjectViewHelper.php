<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * An intangible item that describes an alignment between a learning resource and a node in an educational framework.
 *
 * schema.org version 3.6
 */
class AlignmentObjectViewHelper extends IntangibleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('alignmentType', 'mixed', 'A category of alignment between the learning resource and the framework node. Recommended values include: \'assesses\', \'teaches\', \'requires\', \'textComplexity\', \'readingLevel\', \'educationalSubject\', and \'educationalLevel\'.');
        $this->registerArgument('educationalFramework', 'mixed', 'The framework to which the resource being described is aligned.');
        $this->registerArgument('targetDescription', 'mixed', 'The description of a node in an established educational framework.');
        $this->registerArgument('targetName', 'mixed', 'The name of a node in an established educational framework.');
        $this->registerArgument('targetUrl', 'mixed', 'The URL of a node in an established educational framework.');
    }
}
