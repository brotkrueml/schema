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
 * A media object, such as an image, video, or audio object embedded in a web page or a downloadable dataset i.e. DataDownload. Note that a creative work may have many media objects associated with it on the same web page. For example, a page about a single song (MusicRecording) may have a music video (VideoObject), and a high and low bandwidth audio stream (2 AudioObject\'s).
 *
 * schema.org version 3.6
 */
class MediaObject extends CreativeWork
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('associatedArticle', 'bitrate', 'contentSize', 'contentUrl', 'duration', 'embedUrl', 'encodesCreativeWork', 'endTime', 'height', 'playerType', 'productionCompany', 'regionsAllowed', 'requiresSubscription', 'startTime', 'uploadDate', 'width');
    }
}
