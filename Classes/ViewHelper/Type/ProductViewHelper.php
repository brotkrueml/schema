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
 * Any offered product or service. For example: a pair of shoes; a concert ticket; the rental of a car; a haircut; or an episode of a TV show streamed online.
 *
 * schema.org version 3.6
 */
class ProductViewHelper extends ThingViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('additionalProperty', 'mixed', 'A property-value pair representing an additional characteristics of the entitity, e.g. a product feature or another characteristic for which there is no matching property in schema.org.');
        $this->registerArgument('aggregateRating', 'mixed', 'The overall rating, based on a collection of reviews or ratings, of the item.');
        $this->registerArgument('audience', 'mixed', 'An intended audience, i.e. a group for whom something was created.');
        $this->registerArgument('award', 'mixed', 'An award won by or for this item.');
        $this->registerArgument('brand', 'mixed', 'The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.');
        $this->registerArgument('category', 'mixed', 'A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.');
        $this->registerArgument('color', 'mixed', 'The color of the product.');
        $this->registerArgument('depth', 'mixed', 'The depth of the item.');
        $this->registerArgument('gtin12', 'mixed', 'The GTIN-12 code of the product, or the product to which the offer refers. The GTIN-12 is the 12-digit GS1 Identification Key composed of a U.P.C. Company Prefix, Item Reference, and Check Digit used to identify trade items. See GS1 GTIN Summary for more details.');
        $this->registerArgument('gtin13', 'mixed', 'The GTIN-13 code of the product, or the product to which the offer refers. This is equivalent to 13-digit ISBN codes and EAN UCC-13. Former 12-digit UPC codes can be converted into a GTIN-13 code by simply adding a preceeding zero. See GS1 GTIN Summary for more details.');
        $this->registerArgument('gtin14', 'mixed', 'The GTIN-14 code of the product, or the product to which the offer refers. See GS1 GTIN Summary for more details.');
        $this->registerArgument('gtin8', 'mixed', 'The GTIN-8 code of the product, or the product to which the offer refers. This code is also known as EAN/UCC-8 or 8-digit EAN. See GS1 GTIN Summary for more details.');
        $this->registerArgument('height', 'mixed', 'The height of the item.');
        $this->registerArgument('isAccessoryOrSparePartFor', 'mixed', 'A pointer to another product (or multiple products) for which this product is an accessory or spare part.');
        $this->registerArgument('isConsumableFor', 'mixed', 'A pointer to another product (or multiple products) for which this product is a consumable.');
        $this->registerArgument('isRelatedTo', 'mixed', 'A pointer to another, somehow related product (or multiple products).');
        $this->registerArgument('isSimilarTo', 'mixed', 'A pointer to another, functionally similar product (or multiple products).');
        $this->registerArgument('itemCondition', 'mixed', 'A predefined value from OfferItemCondition or a textual description of the condition of the product or service, or the products or services included in the offer.');
        $this->registerArgument('logo', 'mixed', 'An associated logo.');
        $this->registerArgument('manufacturer', 'mixed', 'The manufacturer of the product.');
        $this->registerArgument('material', 'mixed', 'A material that something is made from, e.g. leather, wool, cotton, paper.');
        $this->registerArgument('model', 'mixed', 'The model of the product. Use with the URL of a ProductModel or a textual representation of the model identifier. The URL of the ProductModel can be from an external source. It is recommended to additionally provide strong product identifiers via the gtin8/gtin13/gtin14 and mpn properties.');
        $this->registerArgument('mpn', 'mixed', 'The Manufacturer Part Number (MPN) of the product, or the product to which the offer refers.');
        $this->registerArgument('offers', 'mixed', 'An offer to provide this item&#x2014;for example, an offer to sell a product, rent the DVD of a movie, perform a service, or give away tickets to an event.');
        $this->registerArgument('productID', 'mixed', 'The product identifier, such as ISBN. For example: meta itemprop="productID" content="isbn:123-456-789".');
        $this->registerArgument('productionDate', 'mixed', 'The date of production of the item, e.g. vehicle.');
        $this->registerArgument('purchaseDate', 'mixed', 'The date the item e.g. vehicle was purchased by the current owner.');
        $this->registerArgument('releaseDate', 'mixed', 'The release date of a product or product model. This can be used to distinguish the exact variant of a product.');
        $this->registerArgument('review', 'mixed', 'A review of the item.');
        $this->registerArgument('sku', 'mixed', 'The Stock Keeping Unit (SKU), i.e. a merchant-specific identifier for a product or service, or the product to which the offer refers.');
        $this->registerArgument('slogan', 'mixed', 'A slogan or motto associated with the item.');
        $this->registerArgument('weight', 'mixed', 'The weight of the product or person.');
        $this->registerArgument('width', 'mixed', 'The width of the item.');
    }
}
