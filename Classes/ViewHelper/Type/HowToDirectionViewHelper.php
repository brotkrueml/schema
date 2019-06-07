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
 * A direction indicating a single action to do in the instructions for how to achieve a result.
 *
 * schema.org version 3.6
 */
class HowToDirectionViewHelper extends ListItemViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('about', 'mixed', 'The subject matter of the content.');
        $this->registerArgument('accessMode', 'mixed', 'The human sensory perceptual system or cognitive faculty through which a person may process or perceive information. Expected values include: auditory, tactile, textual, visual, colorDependent, chartOnVisual, chemOnVisual, diagramOnVisual, mathOnVisual, musicOnVisual, textOnVisual.');
        $this->registerArgument('accessModeSufficient', 'mixed', 'A list of single or combined accessModes that are sufficient to understand all the intellectual content of a resource. Expected values include:  auditory, tactile, textual, visual.');
        $this->registerArgument('accessibilityAPI', 'mixed', 'Indicates that the resource is compatible with the referenced accessibility API (WebSchemas wiki lists possible values).');
        $this->registerArgument('accessibilityControl', 'mixed', 'Identifies input methods that are sufficient to fully control the described resource (WebSchemas wiki lists possible values).');
        $this->registerArgument('accessibilityFeature', 'mixed', 'Content features of the resource, such as accessible media, alternatives and supported enhancements for accessibility (WebSchemas wiki lists possible values).');
        $this->registerArgument('accessibilityHazard', 'mixed', 'A characteristic of the described resource that is physiologically dangerous to some users. Related to WCAG 2.0 guideline 2.3 (WebSchemas wiki lists possible values).');
        $this->registerArgument('accessibilitySummary', 'mixed', 'A human-readable summary of specific accessibility features or deficiencies, consistent with the other accessibility metadata but expressing subtleties such as "short descriptions are present but long descriptions will be needed for non-visual users" or "short descriptions are present and no long descriptions are needed."');
        $this->registerArgument('accountablePerson', 'mixed', 'Specifies the Person that is legally accountable for the CreativeWork.');
        $this->registerArgument('afterMedia', 'mixed', 'A media object representing the circumstances after performing this direction.');
        $this->registerArgument('aggregateRating', 'mixed', 'The overall rating, based on a collection of reviews or ratings, of the item.');
        $this->registerArgument('alternativeHeadline', 'mixed', 'A secondary title of the CreativeWork.');
        $this->registerArgument('associatedMedia', 'mixed', 'A media object that encodes this CreativeWork. This property is a synonym for encoding.');
        $this->registerArgument('audience', 'mixed', 'An intended audience, i.e. a group for whom something was created.');
        $this->registerArgument('audio', 'mixed', 'An embedded audio object.');
        $this->registerArgument('author', 'mixed', 'The author of this content or rating. Please note that author is special in that HTML 5 provides a special mechanism for indicating authorship via the rel tag. That is equivalent to this and may be used interchangeably.');
        $this->registerArgument('award', 'mixed', 'An award won by or for this item.');
        $this->registerArgument('beforeMedia', 'mixed', 'A media object representing the circumstances before performing this direction.');
        $this->registerArgument('character', 'mixed', 'Fictional person connected with a creative work.');
        $this->registerArgument('citation', 'mixed', 'A citation or reference to another creative work, such as another publication, web page, scholarly article, etc.');
        $this->registerArgument('comment', 'mixed', 'Comments, typically from users.');
        $this->registerArgument('commentCount', 'mixed', 'The number of comments this CreativeWork (e.g. Article, Question or Answer) has received. This is most applicable to works published in Web sites with commenting system; additional comments may exist elsewhere.');
        $this->registerArgument('contentLocation', 'mixed', 'The location depicted or described in the content. For example, the location in a photograph or painting.');
        $this->registerArgument('contentRating', 'mixed', 'Official rating of a piece of content&#x2014;for example,\'MPAA PG-13\'.');
        $this->registerArgument('contributor', 'mixed', 'A secondary contributor to the CreativeWork or Event.');
        $this->registerArgument('copyrightHolder', 'mixed', 'The party holding the legal copyright to the CreativeWork.');
        $this->registerArgument('copyrightYear', 'mixed', 'The year during which the claimed copyright for the CreativeWork was first asserted.');
        $this->registerArgument('creator', 'mixed', 'The creator/author of this CreativeWork. This is the same as the Author property for CreativeWork.');
        $this->registerArgument('dateCreated', 'mixed', 'The date on which the CreativeWork was created or the item was added to a DataFeed.');
        $this->registerArgument('dateModified', 'mixed', 'The date on which the CreativeWork was most recently modified or when the item\'s entry was modified within a DataFeed.');
        $this->registerArgument('datePublished', 'mixed', 'Date of first broadcast/publication.');
        $this->registerArgument('discussionUrl', 'mixed', 'A link to the page containing the comments of the CreativeWork.');
        $this->registerArgument('duringMedia', 'mixed', 'A media object representing the circumstances while performing this direction.');
        $this->registerArgument('editor', 'mixed', 'Specifies the Person who edited the CreativeWork.');
        $this->registerArgument('educationalAlignment', 'mixed', 'An alignment to an established educational framework.');
        $this->registerArgument('educationalUse', 'mixed', 'The purpose of a work in the context of education; for example, \'assignment\', \'group work\'.');
        $this->registerArgument('encoding', 'mixed', 'A media object that encodes this CreativeWork. This property is a synonym for associatedMedia.');
        $this->registerArgument('encodingFormat', 'mixed', 'Media type typically expressed using a MIME format (see IANA site and MDN reference) e.g. application/zip for a SoftwareApplication binary, audio/mpeg for .mp3 etc.).');
        $this->registerArgument('exampleOfWork', 'mixed', 'A creative work that this work is an example/instance/realization/derivation of.');
        $this->registerArgument('expires', 'mixed', 'Date the content expires and is no longer useful or available. For example a VideoObject or NewsArticle whose availability or relevance is time-limited, or a ClaimReview fact check whose publisher wants to indicate that it may no longer be relevant (or helpful to highlight) after some date.');
        $this->registerArgument('funder', 'mixed', 'A person or organization that supports (sponsors) something through some kind of financial contribution.');
        $this->registerArgument('genre', 'mixed', 'Genre of the creative work, broadcast channel or group.');
        $this->registerArgument('hasPart', 'mixed', 'Indicates an item or CreativeWork that is part of this item, or CreativeWork (in some sense).');
        $this->registerArgument('headline', 'mixed', 'Headline of the article.');
        $this->registerArgument('inLanguage', 'mixed', 'The language of the content or performance or used in an action. Please use one of the language codes from the IETF BCP 47 standard. See also availableLanguage.');
        $this->registerArgument('interactionStatistic', 'mixed', 'The number of interactions for the CreativeWork using the WebSite or SoftwareApplication. The most specific child type of InteractionCounter should be used.');
        $this->registerArgument('interactivityType', 'mixed', 'The predominant mode of learning supported by the learning resource. Acceptable values are \'active\', \'expositive\', or \'mixed\'.');
        $this->registerArgument('isAccessibleForFree', 'mixed', 'A flag to signal that the item, event, or place is accessible for free.');
        $this->registerArgument('isBasedOn', 'mixed', 'A resource that was used in the creation of this resource. This term can be repeated for multiple sources. For example, http://example.com/great-multiplication-intro.html.');
        $this->registerArgument('isFamilyFriendly', 'mixed', 'Indicates whether this content is family friendly.');
        $this->registerArgument('isPartOf', 'mixed', 'Indicates an item or CreativeWork that this item, or CreativeWork (in some sense), is part of.');
        $this->registerArgument('keywords', 'mixed', 'Keywords or tags used to describe this content. Multiple entries in a keywords list are typically delimited by commas.');
        $this->registerArgument('learningResourceType', 'mixed', 'The predominant type or kind characterizing the learning resource. For example, \'presentation\', \'handout\'.');
        $this->registerArgument('license', 'mixed', 'A license document that applies to this content, typically indicated by URL.');
        $this->registerArgument('locationCreated', 'mixed', 'The location where the CreativeWork was created, which may not be the same as the location depicted in the CreativeWork.');
        $this->registerArgument('mainEntity', 'mixed', 'Indicates the primary entity described in some page or other CreativeWork.');
        $this->registerArgument('material', 'mixed', 'A material that something is made from, e.g. leather, wool, cotton, paper.');
        $this->registerArgument('mentions', 'mixed', 'Indicates that the CreativeWork contains a reference to, but is not necessarily about a concept.');
        $this->registerArgument('offers', 'mixed', 'An offer to provide this item&#x2014;for example, an offer to sell a product, rent the DVD of a movie, perform a service, or give away tickets to an event.');
        $this->registerArgument('performTime', 'mixed', 'The length of time it takes to perform instructions or a direction (not including time to prepare the supplies), in ISO 8601 duration format.');
        $this->registerArgument('prepTime', 'mixed', 'The length of time it takes to prepare the items to be used in instructions or a direction, in ISO 8601 duration format.');
        $this->registerArgument('producer', 'mixed', 'The person or organization who produced the work (e.g. music album, movie, tv/radio series etc.).');
        $this->registerArgument('provider', 'mixed', 'The service provider, service operator, or service performer; the goods producer. Another party (a seller) may offer those services or goods on behalf of the provider. A provider may also serve as the seller.');
        $this->registerArgument('publication', 'mixed', 'A publication event associated with the item.');
        $this->registerArgument('publisher', 'mixed', 'The publisher of the creative work.');
        $this->registerArgument('publishingPrinciples', 'mixed', 'The publishingPrinciples property indicates (typically via URL) a document describing the editorial principles of an Organization (or individual e.g. a Person writing a blog) that relate to their activities as a publisher, e.g. ethics or diversity policies. When applied to a CreativeWork (e.g. NewsArticle) the principles are those of the party primarily responsible for the creation of the CreativeWork.');
        $this->registerArgument('recordedAt', 'mixed', 'The Event where the CreativeWork was recorded. The CreativeWork may capture all or part of the event.');
        $this->registerArgument('releasedEvent', 'mixed', 'The place and time the release was issued, expressed as a PublicationEvent.');
        $this->registerArgument('review', 'mixed', 'A review of the item.');
        $this->registerArgument('schemaVersion', 'mixed', 'Indicates (by URL or string) a particular version of a schema used in some CreativeWork. For example, a document could declare a schemaVersion using an URL such as http://schema.org/version/2.0/ if precise indication of schema version was required by some application.');
        $this->registerArgument('sourceOrganization', 'mixed', 'The Organization on whose behalf the creator was working.');
        $this->registerArgument('spatial', 'mixed', 'The "spatial" property can be used in cases when more specific properties');
        $this->registerArgument('spatialCoverage', 'mixed', 'The spatialCoverage of a CreativeWork indicates the place(s) which are the focus of the content. It is a subproperty of');
        $this->registerArgument('sponsor', 'mixed', 'A person or organization that supports a thing through a pledge, promise, or financial contribution. e.g. a sponsor of a Medical Study or a corporate sponsor of an event.');
        $this->registerArgument('supply', 'mixed', 'A sub-property of instrument. A supply consumed when performing instructions or a direction.');
        $this->registerArgument('temporal', 'mixed', 'The "temporal" property can be used in cases where more specific properties');
        $this->registerArgument('temporalCoverage', 'mixed', 'The temporalCoverage of a CreativeWork indicates the period that the content applies to, i.e. that it describes, either as a DateTime or as a textual string indicating a time period in ISO 8601 time interval format. In');
        $this->registerArgument('text', 'mixed', 'The textual content of this CreativeWork.');
        $this->registerArgument('thumbnailUrl', 'mixed', 'A thumbnail image relevant to the Thing.');
        $this->registerArgument('timeRequired', 'mixed', 'Approximate or typical time it takes to work with or through this learning resource for the typical intended target audience, e.g. \'PT30M\', \'PT1H25M\'.');
        $this->registerArgument('tool', 'mixed', 'A sub property of instrument. An object used (but not consumed) when performing instructions or a direction.');
        $this->registerArgument('totalTime', 'mixed', 'The total time required to perform instructions or a direction (including time to prepare the supplies), in ISO 8601 duration format.');
        $this->registerArgument('translator', 'mixed', 'Organization or person who adapts a creative work to different languages, regional differences and technical requirements of a target market, or that translates during some event.');
        $this->registerArgument('typicalAgeRange', 'mixed', 'The typical expected age range, e.g. \'7-9\', \'11-\'.');
        $this->registerArgument('version', 'mixed', 'The version of the CreativeWork embodied by a specified resource.');
        $this->registerArgument('video', 'mixed', 'An embedded video object.');
        $this->registerArgument('workExample', 'mixed', 'Example/instance/realization/derivation of the concept of this creative work. eg. The paperback edition, first edition, or eBook.');
    }
}
