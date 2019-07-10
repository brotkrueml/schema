.. include:: ../Includes.txt


.. _web-page-type:

================
The WebPage type
================

Target group: **Developers**


Introduction
============

There are several web page types available to characterise the content of a web page. A list of the types can be found
in the section ":ref:`Available Web Page Types <webpage-types-list>`".

The ``WebPage`` type and its descendants (like [AboutPage](https://schema.org/AboutPage)
or [ImageGallery](https://schema.org/ImageGallery)) can only appear once on a web page - as opposed to the other types.

This extension defines a new page field *:ref:`Specific type of web page <for-editors>`* for the page properties. Choose
the appropriate type for the page and the schema markup is added automatically to the page (if the corresponding
:ref:`configuration setting <configuration-automaticWebPageSchemaGeneration>` is activated). If the configuration option
is set and the according page has an expiration date set, the according property ``expires`` will be set in the markup.

But you have various options to set the web page type on your own. This can be the case, if you want to define the
``mainEntity`` property for a blog article or a product.

But now let's get our hands on the code.


Using the API
-------------

As you saw in a previous chapter you can use the :ref:`API <api>` to define the schema for a page. The ``WebPage`` type
is no exception to that. Define a ``WebPage`` type for a page via the API:

.. code-block:: php

   $itemPage = new \Brotkrueml\Schema\Model\Type\ItemPage()
   $this->schemaManager->addType($itemPage);

That's it. But you can add one or more properties to it - let's define a page with a product as primary content:

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

   $itemPage = (new \Brotkrueml\Schema\Model\Type\ItemPage())
      ->setProperty('mainEntity', $product)
   ;

   $schemaManager->addType($itemPage);

The example is rendered as JSON-LD:

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

If you define a web page on your own, this overrules the page field value of the specific type of web page.

.. TIP::

   You don't have to define a web page type, if you only want to set the main entity of the page. You can also set the
   main entity independently of the web page. Have a look at the chapter :ref:`Main entity <main-entity-of-web-page>`.


Using the view helpers
----------------------

But imagine you don't have the possibility to add PHP code to an extension (e.g. it is a third-party extension). So
the view helpers come into the game. Let's implement the same example as above with view helpers:

.. code-block:: html

   <schema:type.itemPage>
      <schema:type.product
         -as="mainEntity"
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
   </schema:type.itemPage>


Remark
------

As mentioned above, only one web page type can exist on a page. But what happens if you set more than one web page type?
Well, the last call wins the race. So you can define it in your Extbase action and set it in a Fluid template - the
template wins.
