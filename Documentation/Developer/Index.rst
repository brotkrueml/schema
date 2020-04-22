.. include:: ../Includes.txt


.. _developer:

===========================
Introduction for developers
===========================

Target group: **Developers**, **Integrators**

.. contents:: Table of Contents
   :depth: 2
   :local:

Introduction
============

The structured markup can be generated in two ways:

* using the :ref:`API <api>`
* with :ref:`view helpers <view-helpers>` in Fluid templates

Each type in the
`schema.org vocabulary <https://schema.org/docs/schemas.html>`__ corresponds to
a **PHP model** that provides the available properties. There is also a
**view helper** for each type that makes it easy to integrate the data into your
website via a Fluid template.

Attention should be paid to the following points:

* A web page can be characterised by different schema.org types as outlined in
  :ref:`this chapter <for-editors>`. The ``WebPage`` type is set automatically
  if the corresponding
  :ref:`configuration option <configuration-automaticWebPageSchemaGeneration>`
  is set. But it can always overridden manually with the desired type and
  properties. The chapter :ref:`web-page-type` is dedicated to this topic.
* A breadcrumb does not only help the user to recognise the location of a
  particular page on the website. It is also helpful for search engines to
  understand the structure of your website. Google honors the website operator
  for using the :ref:`breadcrumb schema markup <breadcrumb>` on a page: It will
  be shown in the search result snippet.
* The :ref:`main entity <main-entity-of-web-page>` of a web page indicates the
  primary entity. It can be set separately from a ``WebPage``.

.. note::

   Please keep in mind: If the seo system extension is installed and the
   checkbox :guilabel:`no_index` on a page is activated, no schema markup is
   shown at all on that page. This makes no sense as the page is ignored by
   search engines and so the markup is also ignored.

   But: If you like to add markup to non-indexed pages, you can use a
   :ref:`slot/PSR-14 <event-de-activate-embedding-of-markup>` event.


Quick dive-in
=============

The `schema.org vocabulary <https://schema.org/docs/schemas.html>`__ consists of
many **types**, like ``Person``, ``Organization``, ``Product``, and so on. They
are written with an upper letter at the beginning of the term.

Each type has several **properties** which characterise the specific type, like
``givenName`` or ``lastName`` for a ``Person``. The properties start with a
lower letter at the beginning in the vocabulary.

The most generic type is ``Thing``. Each other type inherits the properties
from one or more other types, e.g: ``Corporation`` is a specific type for
``Organization`` and defines a new property. ``Organization`` itself is a
specific type of ``Thing`` and inherits the properties of ``Thing`` and defines
many more properties characterising this type.

You can retrieve the information about a type or property from the URL
*https://schema.org/* followed by the term name. (e.g.
*https://schema.org/Person*) or the name of the property
(e.g. *https://schema.org/givenName*).

.. index:: Model

Models
------

This extension provides model classes for each type under the PHP namespace
:php:`\Brotkrueml\Schema\Model\Type`. For example, the type ``Thing`` is mapped
to the model :php:`\Brotkrueml\Schema\Model\Type\Thing`, which knows about the
according schema.org properties. A property value can be set with an according
method::

   $thing = \Brotkrueml\Schema\Type\TypeFactory::createType('Thing');
   $thing->setProperty('name', 'A thing');

The schema manager connects the type models to the page and is responsible for
generating the markup on the web page::

   $schemaManager = TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      \Brotkrueml\Schema\Manager\SchemaManager::class
   );
   $schemaManager->addType($thing);

The chapter :ref:`api` describes in-depth how to use the models
and the schema manager.

.. note::

   The models were generated from the schema.org definition and will be updated
   as the standard evolves.


View helpers
------------

For usage in Fluid templates, each type is mapped to a view helper in the
``schema:type`` namespace. You assign the type properties as view helper
arguments, e.g.:

.. code-block:: html

    <schema:type.thing name="A thing"/>

The view helpers can be nested into each other.

The chapter :ref:`view-helpers` explains the usage of
the view helpers in detail.

.. note::
   The view helpers were generated from the schema.org definition and will be
   updated as the standard evolves.
