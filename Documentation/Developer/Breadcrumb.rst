.. include:: ../Includes.txt

.. index:: Breadcrumb

.. _breadcrumb:

=====================
The breadcrumb markup
=====================

Target group: **Developers**

.. contents:: Table of Contents
   :depth: 2
   :local:


Introduction
============

A breadcrumb is an essential part of a web page. It gives the user an idea of
where he is on the web site. He can also navigate to parent pages. But for
search engines a breadcrumb is also essential to understand the structure of a
web site. Last but not least, the breadcrumb is shown in the search result
snippet if structured markup for the breadcrumb is available.

There can also be more than one breadcrumb on a page, Google gives an example in
his guidelines for a
`breadcrumb <https://developers.google.com/search/docs/data-types/breadcrumb>`__.

.. index:: Breadcrumb via API

.. _breadcrumb-api:

Using the API
=============

You can define a breadcrumb with the :ref:`API <api>` as you may already
guessed. For example, you have defined a breadcrumb somewhere::

   $breadcrumb = [
      'Some product category' => 'http://example.org/some-product-category/',
      'Some product subcategory' => 'http://example.org/some-product-subcategory/',
      'Some fancy product' => 'http://example.org/some-fancy-product/',
   ];

Now you can iterate over the pages::

   $breadcrumbList = (new \Brotkrueml\Schema\Model\Type\BreadcrumbList());
   $counter = 0;
   foreach ($breadcrumb as $item) {
      $counter++;

      $breadcrumbList->addProperty(
         'itemListElement',
         (new \Brotkrueml\Schema\Model\Type\ListItem()
            ->setProperties([
               'name' => 'Some product category',
               'item' => 'https://example.org/some-product-category/',
               'position' => $counter,
            ])
         )
      );
   }

   $schemaManager = GeneralUtility::makeInstance(SchemaManager::class);
   $schemaManager->addType($breadcrumbList);

This results in the following schema markup:

.. code-block:: json

   {
      "@context": "http://schema.org",
      "@type": "WebPage",
      "breadcrumb": {
         "@type": "BreadcrumbList",
         "itemListElement": [
            {
               "@type": "ListItem",
               "item": "http://example.org/some-product-category/",
               "name": "Some product category",
               "position": "1"
            },
            {
               "@type": "ListItem",
               "item": "http://example.org/some-product-subcategory/",
               "name": "Some product subcategory",
               "position": "2"
            },
            {
               "@type": "ListItem",
               "item": "hhttp://example.org/some-fancy-product/",
               "name": "Some fancy product",
               "position": "3"
            }
         ]
      }
   }

As you can see, the breadcrumb is embedded in a ``WebPage`` automatically.

.. index:: Breadcrumb via view helpers

.. _breadcrumb-viewhelpers:

Using the view helpers
======================

.. index:: breadcrumbList view helper

View helper :html:`<schema:type.breadcrumbList>`
------------------------------------------------

The schema markup can also be achieved by a view helper in a Fluid template:

.. code-block:: html

   <schema:type.breadcrumbList>
      <f:for each="{breadcrumb}" as="item" iteration="iterator">
         <schema:type.listItem
            -as="itemListElement"
            name="{item.title}"
            item="{item.link}"
            position="{iterator.cycle}"
         />
      </f:for>
   </schema:type.breadcrumbList>

It is also possible to use it in combination with one of the ``WebPage`` types:

.. code-block:: html

   <schema:type.itemPage>
      <schema:type.breadcrumbList -as="breadcrumb">
         <f:for each="{breadcrumb}" as="item" iteration="iterator">
            <schema:type.listItem
               -as="itemListElement"
               name="{item.title}"
               item="{item.link}"
               position="{iterator.cycle}"
            />
         </f:for>
      </schema:type.breadcrumbList>
   </schema:type.itemPage>


.. index:: breadcrumb view helper

.. _breadcrumb-view-helper:

View helper :html:`<schema:breadcrumb>`
---------------------------------------

But mostly you will have the breadcrumb structure in a Fluid variable created by
a MenuProcessor in TypoScript:

.. code-block:: typoscript

   page = PAGE
   page {
      # ... some other configuration ...

      10 = FLUIDTEMPLATE
      10 {
         # ... some other configuration ...
         dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\MenuProcessor
            10 {
                special = rootline
                as = breadcrumb
            }
         }
      }
   }

Wouldn't it be cool to use this variable as input for the schema markup without
iterating over the structure? So, let's use the breadcrumb view helper for that:

.. code-block:: html

   <schema:breadcrumb breadcrumb="{breadcrumb}"/>

That's it.

The best place to use this view helper is in the template where you generate
your visual representation of the breadcrumb for your users.

Normally the home page is part of the generated breadcrumb, but this is not
necessary for the schema markup - so the home page is omitted. But if you really
want to have it in the markup (or you have a breadcrumb generated on your own
without the home page), you can use the attribute :html:`renderFirstItem` and
set it to :html:`1`:

.. code-block:: html

   <schema:breadcrumb breadcrumb="{breadcrumb}" renderFirstItem="1"/>

You can build your own breadcrumb array and assign it to the template. It should
have the following structure::

   $breadcrumb = [
      [
         'title' => 'Home page',
         'link' => '/',
         'data' => [
            'tx_schema_webpagetype' => 'WebPage',
         ],
      ],
      [
         'title' => 'Some product category',
         'link' => '/some-product-category/',
         'data' => [
            'tx_schema_webpagetype' => 'CollectionPage',
         ],
      ],
      [
         'title' => 'Some product subcategory',
         'link' => '/some-product-subcategory/',
         'data' => [
            'tx_schema_webpagetype' => 'CollectionPage',
         ],
      ],
      [
         'title' => 'Some fancy product',
         'link' => '/some-fancy-product/',
         'data' => [
            'tx_schema_webpagetype' => 'ItemPage',
         ],
      ],
   ];

If the key :php:`tx_schema_webpagetype` is omitted it defaults to ``WebPage``.

Remarks
-------

* The home page should not be included into the markup.
* Please keep in mind that according to the Google Structured Data Testing Tool,
  only the type ``BreadcrumbList`` is allowed for the breadcrumb property -
  either the schema.org definition allows strings. Other types than the
  BreadcrumbList are ignored by the schema manager.
* It is intended that the breadcrumb is not automatically rendered out of the
  page structure of your TYPO3 installation, because it is possible to extend
  the breadcrumb with own MenuProcessors like in the
  `news extension <https://docs.typo3.org/typo3cms/extensions/news/7.2.0/Misc/Changelog/7-2-0.html#custom-menu-processor>`__.
