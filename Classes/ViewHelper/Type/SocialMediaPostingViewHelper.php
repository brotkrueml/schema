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
 * A post to a social media platform, including blog posts, tweets, Facebook posts, etc.
 *
 * schema.org version 3.6
 */
class SocialMediaPostingViewHelper extends ArticleViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('sharedContent', 'mixed', 'A CreativeWork such as an image, video, or audio clip shared as part of this posting.');
    }
}
