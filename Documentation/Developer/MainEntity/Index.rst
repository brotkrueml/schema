.. include:: ../Includes.txt


.. _main-entity-of-web-page:

=========================
Main Entity of a Web Page
=========================

Target group: **Developers**


Introduction
============

A ``WebPage`` type has a property ``mainEntity``, which indicates the primary content of a page. Every
type is allowed - although some types doesn't make sense (e.g. a breadcrumb cannot be the primary content).

.. NOTE::
   There can be only one main entity at a time. If more than one main entity is set, the last one added has priority.
   The ones set before are rendered as root types.


Using the API
-------------

The main entity of a web page can be defined with the API. Let's start with an example, which sets a product
as the primary content:

.. code-block:: php

   $aggregateRating = (new \Brotkrueml\Schema\Model\Type\Product())
      ->setProperty('ratingValue', '4')
      ->setProperty('reviewCount', '126')
   ;

   $product = (new \Brotkrueml\Schema\Model\Type\Product())
      ->setProperties([
         'name' => 'Some fancy product',
         'color' => 'blue',
         'material' => 'wood',
         'image' => 'http://example.org/some-fancy-product.jpg',
         'aggregateRating' => $aggregateRating,
      ])
   ;

   $schemaManager->setMainEntityOfWebPage($product);

The above example is then rendered as JSON-LD. We assume, that the ``WebPage`` type is set to ``ItemPage`` - either in
the page properties or via the API or a view helper.

.. code-block:: json

   {
      "@context": "http://schema.org",
      "@type": "ItemPage",
      "mainEntity": {
         "@type": "Product",
         "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4",
            "reviewCount": "126"
         },
         "color": "blue",
         "image": "http://example.org/some-fancy-product.jpg",
         "material": "wood",
         "name": "Some fancy product"
      }
   }

.. NOTE::
   If the ``WebPage`` type is not defined, because in the extension configuration the
   :ref:`according setting <configuration-automaticWebPageSchemaGeneration>` is disabled, then the main entity is
   rendered as a root type.


Using the view helpers
----------------------

You can define the main entity also in a view helper:

.. code-block:: html

   <schema:type.product
      -as="mainEntity"
      -isMainEntityOfWebPage="1"
      name="Some fancy product"
      color="blue"
      material="wood"
      image="http://example.org/some-fancy-product.jpg"
   >
      <schema:type.aggregateRating
         -as="aggregateRating"
         ratingValue="4"
         reviewCount="126"
      />
   </schema:type.product>


Remarks:
~~~~~~~~

* You can set the view helper argument ``-isMainEntityOfWebPage`` only in the main type view helper, not in a child
  type view helper.
* If the argument ``-isMainEntityOfWebPage`` is used in more the one view helper, the last definition is the winner
  and will be shown as main entity. The others are rendered as root types.
