.. include:: /Includes.rst.txt

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

A `WebPage` type provides a property `mainEntity`, which indicates the
primary content of a page. Every type is allowed - although some types does not
make sense (for example, a breadcrumb cannot be the primary content).

.. note::
   Technically, there can be more than one main entity at a time. For example,
   if you have a `FAQPage` you will usually assign `more than one question`_
   as `mainEntity`.


Using the API
=============

The main entity of a web page can be defined with the API. Let's start with an
example that specifies a product as the primary content:

.. literalinclude:: _MainEntity/_MyController.php
   :language: php
   :caption: EXT:my_extension/Classes/Controller/MyController.php
   :emphasize-lines: 22-35

The above example is rendered as JSON-LD. Let's assume the `WebPage` type is
set to `ItemPage` - either in the page properties or via the API or a view
helper.

.. code-block:: json

   {
      "@context": "https://schema.org/",
      "@type": "ItemPage",
      "mainEntity": {
         "@type": "Product",
         "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4",
            "reviewCount": "126"
         },
         "color": "blue",
         "image": "https://example.org/some-fancy-product.jpg",
         "material": "wood",
         "name": "Some fancy product"
      }
   }

.. note::
   If the `WebPage` type is not defined because the
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
      image="https://example.org/some-fancy-product.jpg"
   >
      <schema:type.aggregateRating
         -as="aggregateRating"
         ratingValue="4"
         reviewCount="126"
      />
   </schema:type.product>


Remark
------

You can set the view helper argument :html:`-isMainEntityOfWebPage` only in the
main type view helper, not in a child type view helper.


.. index::
   single: Prioritisation (main entity)

.. _main-entity-prioritisation:

Prioritisation
==============

Main entities can be prioritised. This is sometimes necessary when different
main entities are defined in different places (for example in a controller,
a Fluid page template or in a content element).

Let's look at an example: In a page template for a blog post, the main entity
is defined as type `BlogPosting`. There are content elements on the page that
display questions and answers for a FAQ. The content element sets the web page
type to 'FAQPage' and also defines the questions as the main entities (to
display as rich snippets on the search results page). However, Google Search
Console shows an error because `BlogPosting` is not allowed as the main entity
of a `FAQPage`.


With the API
------------

The main entity of the API example above can be prioritised by setting the
second argument to :php:`true`:

.. code-block:: php

   $schemaManager->addMainEntityOfWebPage($product, true);


With view helpers
-----------------

Let's look at the example described in the introduction. In a page template, a
`BlogPosting` type is defined as the main entity of the page:

.. code-block:: html
   :emphasize-lines: 3

   <!-- This is defined in a page template -->
   <schema:type.blogPosting
      -isMainEntityOfWebPage="1"
      name="A blog post"
   />

And the FAQ is rendered in the template of a content element. To prioritise
these types, :html:`-isMainEntityOfWebPage` is set to `2`:

.. code-block:: html
   :emphasize-lines: 5

   <!-- This is defined in a content element template -->
   <schema:type.fAQPage/>
   <f:for each="{questions}" as="question">
      <schema:type.question
         -isMainEntityOfWebPage="2"
         name="{question.title}"
      />
   </f:for>

This results in the following output:

.. code-block:: json
   :emphasize-lines: 5-11

   {
      "@context": "https://schema.org/",
      "@graph": [{
         "@type": "FAQPage",
         "mainEntity":[{
            "@type": "Question",
            "name": "Question #1"
         }, {
            "@type": "Question",
            "name": "Question #2"
         }]
      }, {
         "@type": "BlogPosting",
         "name": "A blog post"
      }]
   }


.. _more than one question: https://developers.google.com/search/docs/data-types/faqpage
