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
 * The most generic type of item.
 *
 * schema.org version 3.6
 */
class ThingViewHelper extends \Brotkrueml\Schema\Core\ViewHelper\AbstractTypeViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('additionalType', 'mixed', 'An additional type for the item, typically used for adding more specific types from external vocabularies in microdata syntax. This is a relationship between something and a class that the thing is in. In RDFa syntax, it is better to use the native RDFa syntax - the \'typeof\' attribute - for multiple types. Schema.org tools may have only weaker understanding of extra types, in particular those defined externally.');
        $this->registerArgument('alternateName', 'mixed', 'An alias for the item.');
        $this->registerArgument('description', 'mixed', 'A description of the item.');
        $this->registerArgument('disambiguatingDescription', 'mixed', 'A sub property of description. A short description of the item used to disambiguate from other, similar items. Information from other properties (in particular, name) may be necessary for the description to be useful for disambiguation.');
        $this->registerArgument('identifier', 'mixed', 'The identifier property represents any kind of identifier for any kind of Thing, such as ISBNs, GTIN codes, UUIDs etc. Schema.org provides dedicated properties for representing many of these, either as textual strings or as URL (URI) links. See background notes for more details.');
        $this->registerArgument('image', 'mixed', 'An image of the item. This can be a URL or a fully described ImageObject.');
        $this->registerArgument('mainEntityOfPage', 'mixed', 'Indicates a page (or other CreativeWork) for which this thing is the main entity being described. See background notes for details.');
        $this->registerArgument('name', 'mixed', 'The name of the item.');
        $this->registerArgument('potentialAction', 'mixed', 'Indicates a potential Action, which describes an idealized action in which this thing would play an \'object\' role.');
        $this->registerArgument('sameAs', 'mixed', 'URL of a reference Web page that unambiguously indicates the item\'s identity. E.g. the URL of the item\'s Wikipedia page, Wikidata entry, or official website.');
        $this->registerArgument('subjectOf', 'mixed', 'A CreativeWork or Event about this Thing..');
        $this->registerArgument('url', 'mixed', 'URL of the item.');
    }
}
