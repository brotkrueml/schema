<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

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
class SocialMediaPosting extends Article
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('sharedContent');
    }
}
