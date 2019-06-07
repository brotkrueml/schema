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
 * A work of art that is primarily visual in character.
 *
 * schema.org version 3.6
 */
class VisualArtworkViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('artEdition', 'mixed', 'The number of copies when multiple copies of a piece of artwork are produced - e.g. for a limited edition of 20 prints, \'artEdition\' refers to the total number of copies (in this example "20").');
        $this->registerArgument('artMedium', 'mixed', 'The material used. (e.g. Oil, Watercolour, Acrylic, Linoprint, Marble, Cyanotype, Digital, Lithograph, DryPoint, Intaglio, Pastel, Woodcut, Pencil, Mixed Media, etc.)');
        $this->registerArgument('artform', 'mixed', 'e.g. Painting, Drawing, Sculpture, Print, Photograph, Assemblage, Collage, etc.');
        $this->registerArgument('artworkSurface', 'mixed', 'The supporting materials for the artwork, e.g. Canvas, Paper, Wood, Board, etc.');
        $this->registerArgument('depth', 'mixed', 'The depth of the item.');
        $this->registerArgument('height', 'mixed', 'The height of the item.');
        $this->registerArgument('width', 'mixed', 'The width of the item.');
    }
}
