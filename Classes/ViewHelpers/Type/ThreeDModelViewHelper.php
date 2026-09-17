<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\ViewHelpers\Type;

use Brotkrueml\Schema\Core\ViewHelpers\AbstractTypeViewHelper;

/**
 * A 3D model represents some kind of 3D content, which may have encodings in one or more MediaObjects. Many 3D formats are available (e.g. see [Wikipedia](https://en.wikipedia.org/wiki/Category:3D_graphics_file_formats)); specific encoding formats can be represented using the encodingFormat property applied to the relevant MediaObject. For the
 * case of a single file published after Zip compression, the convention of appending '+zip' to the encodingFormat can be used. Geospatial, AR/VR, artistic/animation, gaming, engineering and scientific content can all be represented using 3DModel.
 */
final class ThreeDModelViewHelper extends AbstractTypeViewHelper
{
    protected string $type = '3DModel';
}
