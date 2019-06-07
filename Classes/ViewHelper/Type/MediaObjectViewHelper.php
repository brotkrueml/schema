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
 * A media object, such as an image, video, or audio object embedded in a web page or a downloadable dataset i.e. DataDownload. Note that a creative work may have many media objects associated with it on the same web page. For example, a page about a single song (MusicRecording) may have a music video (VideoObject), and a high and low bandwidth audio stream (2 AudioObject\'s).
 *
 * schema.org version 3.6
 */
class MediaObjectViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('associatedArticle', 'mixed', 'A NewsArticle associated with the Media Object.');
        $this->registerArgument('bitrate', 'mixed', 'The bitrate of the media object.');
        $this->registerArgument('contentSize', 'mixed', 'File size in (mega/kilo) bytes.');
        $this->registerArgument('contentUrl', 'mixed', 'Actual bytes of the media object, for example the image file or video file.');
        $this->registerArgument('duration', 'mixed', 'The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.');
        $this->registerArgument('embedUrl', 'mixed', 'A URL pointing to a player for a specific video. In general, this is the information in the src element of an embed tag and should not be the same as the content of the loc tag.');
        $this->registerArgument('encodesCreativeWork', 'mixed', 'The CreativeWork encoded by this media object.');
        $this->registerArgument('endTime', 'mixed', 'The endTime of something. For a reserved event or service (e.g. FoodEstablishmentReservation), the time that it is expected to end. For actions that span a period of time, when the action was performed. e.g. John wrote a book from January to December. For media, including audio and video, it\'s the time offset of the end of a clip within a larger file.');
        $this->registerArgument('height', 'mixed', 'The height of the item.');
        $this->registerArgument('playerType', 'mixed', 'Player type required&#x2014;for example, Flash or Silverlight.');
        $this->registerArgument('productionCompany', 'mixed', 'The production company or studio responsible for the item e.g. series, video game, episode etc.');
        $this->registerArgument('regionsAllowed', 'mixed', 'The regions where the media is allowed. If not specified, then it\'s assumed to be allowed everywhere. Specify the countries in ISO 3166 format.');
        $this->registerArgument('requiresSubscription', 'mixed', 'Indicates if use of the media require a subscription  (either paid or free). Allowed values are true or false (note that an earlier version had \'yes\', \'no\').');
        $this->registerArgument('startTime', 'mixed', 'The startTime of something. For a reserved event or service (e.g. FoodEstablishmentReservation), the time that it is expected to start. For actions that span a period of time, when the action was performed. e.g. John wrote a book from January to December. For media, including audio and video, it\'s the time offset of the start of a clip within a larger file.');
        $this->registerArgument('uploadDate', 'mixed', 'Date when this media object was uploaded to this site.');
        $this->registerArgument('width', 'mixed', 'The width of the item.');
    }
}
