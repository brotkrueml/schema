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
 * A web page. Every web page is implicitly assumed to be declared to be of type WebPage, so the various properties about that webpage, such as breadcrumb may be used. We recommend explicit declaration if these properties are specified, but if they are found outside of an itemscope, they will be assumed to be about the page.
 *
 * schema.org version 3.6
 */
class WebPageViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('breadcrumb', 'mixed', 'A set of links that can help a user understand and navigate a website hierarchy.');
        $this->registerArgument('lastReviewed', 'mixed', 'Date on which the content on this web page was last reviewed for accuracy and/or completeness.');
        $this->registerArgument('mainContentOfPage', 'mixed', 'Indicates if this web page element is the main subject of the page.');
        $this->registerArgument('primaryImageOfPage', 'mixed', 'Indicates the main image on the page.');
        $this->registerArgument('relatedLink', 'mixed', 'A link related to this web page, for example to other related web pages.');
        $this->registerArgument('reviewedBy', 'mixed', 'People or organizations that have reviewed the content on this web page for accuracy and/or completeness.');
        $this->registerArgument('significantLink', 'mixed', 'One of the more significant URLs on the page. Typically, these are the non-navigation links that are clicked on the most.');
        $this->registerArgument('speakable', 'mixed', 'Indicates sections of a Web page that are particularly \'speakable\' in the sense of being highlighted as being especially appropriate for text-to-speech conversion. Other sections of a page may also be usefully spoken in particular circumstances; the \'speakable\' property serves to indicate the parts most likely to be generally useful for speech.');
        $this->registerArgument('specialty', 'mixed', 'One of the domain specialities to which this web page\'s content applies.');
    }
}
