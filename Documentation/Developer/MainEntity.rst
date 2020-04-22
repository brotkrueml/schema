.. include:: ../Includes.txt

.. index::
   single: Main entity of web page
   seealso: Main entity of web page; WebPage

.. _main-entity-of-web-page:

=========================
Main entity of a web page
=========================

Target group: **Developers**

.. contents:: Table of Contents
   :depth: 1
   :local:

Introduction
============

A ``WebPage`` type provides a property ``mainEntity``, which indicates the
primary content of a page. Every type is allowed - although some types doesn't
make sense (e.g. a breadcrumb cannot be the primary content).

.. note::
   Technically, there can be more than one main entity at a time. For example,
   if you have a ``FAQPage`` you will usually assign `more than one question
   <https://developers.google.com/search/docs/data-types/faqpage>`__ as
   ``mainEntity``.


Using the API
=============

The main entity of a web page can be defined with the API. Let's start with an
example that specifies a product as the primary content::

   $aggregateRating = \Brotkrueml\Schema\Type\TypeFactory::createType('AggregateRating');
      ->setProperty('ratingValue', '4')
      ->setProperty('reviewCount', '126')
   ;

   $product = \Brotkrueml\Schema\Type\TypeFactory::createType('Product')
      ->setProperties([
         'name' => 'Some fancy product',
         'color' => 'blue',
         'material' => 'wood',
         'image' => 'http://example.org/some-fancy-product.jpg',
         'aggregateRating' => $aggregateRating,
      ])
   ;

   $schemaManager->addMainEntityOfWebPage($product);

The above example is rendered as JSON-LD. Let's assume the ``WebPage`` type is
set to ``ItemPage`` - either in the page properties or via the API or a view
helper.

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

.. note::

   If the ``WebPage`` type is not defined because the
   :ref:`appropriate setting<configuration-automaticWebPageSchemaGeneration>`
   is disabled in the extension configuration, the main entity is rendered as
   a root type.


Using the view helpers
======================

You can define the main entity also in a view helper:

.. code-block:: html
   :emphasize-lines: 3

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


Remark
~~~~~~

You can set the view helper argument :html:`-isMainEntityOfWebPage` only in the
main type view helper, not in a child type view helper.
