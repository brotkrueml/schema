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
 * An organization such as a school, NGO, corporation, club, etc.
 *
 * schema.org version 3.6
 */
class OrganizationViewHelper extends ThingViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('address', 'mixed', 'Physical address of the item.');
        $this->registerArgument('aggregateRating', 'mixed', 'The overall rating, based on a collection of reviews or ratings, of the item.');
        $this->registerArgument('alumni', 'mixed', 'Alumni of an organization.');
        $this->registerArgument('areaServed', 'mixed', 'The geographic area where a service or offered item is provided.');
        $this->registerArgument('award', 'mixed', 'An award won by or for this item.');
        $this->registerArgument('brand', 'mixed', 'The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.');
        $this->registerArgument('contactPoint', 'mixed', 'A contact point for a person or organization.');
        $this->registerArgument('department', 'mixed', 'A relationship between an organization and a department of that organization, also described as an organization (allowing different urls, logos, opening hours). For example: a store with a pharmacy, or a bakery with a cafe.');
        $this->registerArgument('dissolutionDate', 'mixed', 'The date that this organization was dissolved.');
        $this->registerArgument('duns', 'mixed', 'The Dun &amp; Bradstreet DUNS number for identifying an organization or business person.');
        $this->registerArgument('email', 'mixed', 'Email address.');
        $this->registerArgument('employee', 'mixed', 'Someone working for this organization.');
        $this->registerArgument('event', 'mixed', 'Upcoming or past event associated with this place, organization, or action.');
        $this->registerArgument('faxNumber', 'mixed', 'The fax number.');
        $this->registerArgument('founder', 'mixed', 'A person who founded this organization.');
        $this->registerArgument('foundingDate', 'mixed', 'The date that this organization was founded.');
        $this->registerArgument('foundingLocation', 'mixed', 'The place where the Organization was founded.');
        $this->registerArgument('funder', 'mixed', 'A person or organization that supports (sponsors) something through some kind of financial contribution.');
        $this->registerArgument('globalLocationNumber', 'mixed', 'The Global Location Number (GLN, sometimes also referred to as International Location Number or ILN) of the respective organization, person, or place. The GLN is a 13-digit number used to identify parties and physical locations.');
        $this->registerArgument('hasOfferCatalog', 'mixed', 'Indicates an OfferCatalog listing for this Organization, Person, or Service.');
        $this->registerArgument('hasPOS', 'mixed', 'Points-of-Sales operated by the organization or person.');
        $this->registerArgument('isicV4', 'mixed', 'The International Standard of Industrial Classification of All Economic Activities (ISIC), Revision 4 code for a particular organization, business person, or place.');
        $this->registerArgument('legalName', 'mixed', 'The official name of the organization, e.g. the registered company name.');
        $this->registerArgument('leiCode', 'mixed', 'An organization identifier that uniquely identifies a legal entity as defined in ISO 17442.');
        $this->registerArgument('location', 'mixed', 'The location of for example where the event is happening, an organization is located, or where an action takes place.');
        $this->registerArgument('logo', 'mixed', 'An associated logo.');
        $this->registerArgument('makesOffer', 'mixed', 'A pointer to products or services offered by the organization or person.');
        $this->registerArgument('member', 'mixed', 'A member of an Organization or a ProgramMembership. Organizations can be members of organizations; ProgramMembership is typically for individuals.');
        $this->registerArgument('memberOf', 'mixed', 'An Organization (or ProgramMembership) to which this Person or Organization belongs.');
        $this->registerArgument('naics', 'mixed', 'The North American Industry Classification System (NAICS) code for a particular organization or business person.');
        $this->registerArgument('numberOfEmployees', 'mixed', 'The number of employees in an organization e.g. business.');
        $this->registerArgument('owns', 'mixed', 'Products owned by the organization or person.');
        $this->registerArgument('parentOrganization', 'mixed', 'The larger organization that this organization is a subOrganization of, if any.');
        $this->registerArgument('publishingPrinciples', 'mixed', 'The publishingPrinciples property indicates (typically via URL) a document describing the editorial principles of an Organization (or individual e.g. a Person writing a blog) that relate to their activities as a publisher, e.g. ethics or diversity policies. When applied to a CreativeWork (e.g. NewsArticle) the principles are those of the party primarily responsible for the creation of the CreativeWork.');
        $this->registerArgument('review', 'mixed', 'A review of the item.');
        $this->registerArgument('seeks', 'mixed', 'A pointer to products or services sought by the organization or person (demand).');
        $this->registerArgument('slogan', 'mixed', 'A slogan or motto associated with the item.');
        $this->registerArgument('sponsor', 'mixed', 'A person or organization that supports a thing through a pledge, promise, or financial contribution. e.g. a sponsor of a Medical Study or a corporate sponsor of an event.');
        $this->registerArgument('subOrganization', 'mixed', 'A relationship between two organizations where the first includes the second, e.g., as a subsidiary. See also: the more specific \'department\' property.');
        $this->registerArgument('taxID', 'mixed', 'The Tax / Fiscal ID of the organization or person, e.g. the TIN in the US or the CIF/NIF in Spain.');
        $this->registerArgument('telephone', 'mixed', 'The telephone number.');
        $this->registerArgument('vatID', 'mixed', 'The Value-added Tax ID of the organization or person.');
    }
}
