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
 * A person (alive, dead, undead, or fictional).
 *
 * schema.org version 3.6
 */
class PersonViewHelper extends ThingViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('additionalName', 'mixed', 'An additional name for a Person, can be used for a middle name.');
        $this->registerArgument('address', 'mixed', 'Physical address of the item.');
        $this->registerArgument('affiliation', 'mixed', 'An organization that this person is affiliated with. For example, a school/university, a club, or a team.');
        $this->registerArgument('alumniOf', 'mixed', 'An organization that the person is an alumni of.');
        $this->registerArgument('award', 'mixed', 'An award won by or for this item.');
        $this->registerArgument('birthDate', 'mixed', 'Date of birth.');
        $this->registerArgument('birthPlace', 'mixed', 'The place where the person was born.');
        $this->registerArgument('brand', 'mixed', 'The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.');
        $this->registerArgument('children', 'mixed', 'A child of the person.');
        $this->registerArgument('colleague', 'mixed', 'A colleague of the person.');
        $this->registerArgument('contactPoint', 'mixed', 'A contact point for a person or organization.');
        $this->registerArgument('deathDate', 'mixed', 'Date of death.');
        $this->registerArgument('deathPlace', 'mixed', 'The place where the person died.');
        $this->registerArgument('duns', 'mixed', 'The Dun &amp; Bradstreet DUNS number for identifying an organization or business person.');
        $this->registerArgument('email', 'mixed', 'Email address.');
        $this->registerArgument('familyName', 'mixed', 'Family name. In the U.S., the last name of an Person. This can be used along with givenName instead of the name property.');
        $this->registerArgument('faxNumber', 'mixed', 'The fax number.');
        $this->registerArgument('follows', 'mixed', 'The most generic uni-directional social relation.');
        $this->registerArgument('funder', 'mixed', 'A person or organization that supports (sponsors) something through some kind of financial contribution.');
        $this->registerArgument('gender', 'mixed', 'Gender of the person. While http://schema.org/Male and http://schema.org/Female may be used, text strings are also acceptable for people who do not identify as a binary gender.');
        $this->registerArgument('givenName', 'mixed', 'Given name. In the U.S., the first name of a Person. This can be used along with familyName instead of the name property.');
        $this->registerArgument('globalLocationNumber', 'mixed', 'The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN) of the respective organization, person, or place. The GLN is a 13-digit number used to identify parties and physical locations.');
        $this->registerArgument('hasOccupation', 'mixed', 'The Person\'s occupation. For past professions, use Role for expressing dates.');
        $this->registerArgument('hasOfferCatalog', 'mixed', 'Indicates an OfferCatalog listing for this Organization, Person, or Service.');
        $this->registerArgument('hasPOS', 'mixed', 'Points-of-Sales operated by the organization or person.');
        $this->registerArgument('height', 'mixed', 'The height of the item.');
        $this->registerArgument('homeLocation', 'mixed', 'A contact location for a person\'s residence.');
        $this->registerArgument('honorificPrefix', 'mixed', 'An honorific prefix preceding a Person\'s name such as Dr/Mrs/Mr.');
        $this->registerArgument('honorificSuffix', 'mixed', 'An honorific suffix preceding a Person\'s name such as M.D. /PhD/MSCSW.');
        $this->registerArgument('isicV4', 'mixed', 'The International Standard of Industrial Classification of All Economic Activities (ISIC), Revision 4 code for a particular organization, business person, or place.');
        $this->registerArgument('jobTitle', 'mixed', 'The job title of the person (for example, Financial Manager).');
        $this->registerArgument('knows', 'mixed', 'The most generic bi-directional social/work relation.');
        $this->registerArgument('makesOffer', 'mixed', 'A pointer to products or services offered by the organization or person.');
        $this->registerArgument('memberOf', 'mixed', 'An Organization (or ProgramMembership) to which this Person or Organization belongs.');
        $this->registerArgument('naics', 'mixed', 'The North American Industry Classification System (NAICS) code for a particular organization or business person.');
        $this->registerArgument('nationality', 'mixed', 'Nationality of the person.');
        $this->registerArgument('netWorth', 'mixed', 'The total financial value of the person as calculated by subtracting assets from liabilities.');
        $this->registerArgument('owns', 'mixed', 'Products owned by the organization or person.');
        $this->registerArgument('parent', 'mixed', 'A parent of this person.');
        $this->registerArgument('performerIn', 'mixed', 'Event that this person is a performer or participant in.');
        $this->registerArgument('publishingPrinciples', 'mixed', 'The publishingPrinciples property indicates (typically via URL) a document describing the editorial principles of an Organization (or individual e.g. a Person writing a blog) that relate to their activities as a publisher, e.g. ethics or diversity policies. When applied to a CreativeWork (e.g. NewsArticle) the principles are those of the party primarily responsible for the creation of the CreativeWork.');
        $this->registerArgument('relatedTo', 'mixed', 'The most generic familial relation.');
        $this->registerArgument('seeks', 'mixed', 'A pointer to products or services sought by the organization or person (demand).');
        $this->registerArgument('sibling', 'mixed', 'A sibling of the person.');
        $this->registerArgument('sponsor', 'mixed', 'A person or organization that supports a thing through a pledge, promise, or financial contribution. e.g. a sponsor of a Medical Study or a corporate sponsor of an event.');
        $this->registerArgument('spouse', 'mixed', 'The person\'s spouse.');
        $this->registerArgument('taxID', 'mixed', 'The Tax / Fiscal ID of the organization or person, e.g. the TIN in the US or the CIF/NIF in Spain.');
        $this->registerArgument('telephone', 'mixed', 'The telephone number.');
        $this->registerArgument('vatID', 'mixed', 'The Value-added Tax ID of the organization or person.');
        $this->registerArgument('weight', 'mixed', 'The weight of the product or person.');
        $this->registerArgument('workLocation', 'mixed', 'A contact location for a person\'s place of work.');
        $this->registerArgument('worksFor', 'mixed', 'Organizations that the person works for.');
    }
}
