.. include:: ../Includes.txt


.. _developer:

================
Developer Corner
================

Target group: **Developers**

The structured data can be defined in two ways:

* using the :ref:`API <api>`
* with :ref:`view helpers <view-helpers>` in Fluid templates

Each type in the `schema.org vocabulary <https://schema.org/docs/schemas.html>`__ corresponds to a **PHP model** that
provides the possible properties. There is also a **view helper** for each type that makes it easy to integrate the data
into your website via a Fluid template.

Introduction
============

The `schema.org vocabulary <https://schema.org/docs/schemas.html>`__ consists of many **types**, like ``Person``,
``Organization``, ``Product``, and so on. They are written with an upper letter at the beginning in the vocabulary.

Each type has several **properties** which characterise the specific type, like ``givenName`` or ``lastName`` for a
``Person``. The properties start with a lower letter at the beginning in the vocabulary.

The most generic type is ``Thing``. Each other type inherits the properties from one or more other types, e.g:
``Corporation`` is a specific type for ``Organization`` and defines a new property. ``Organization`` itself is a specific
type of ``Thing`` and inherits the properties of ``Thing`` and defines many other properties characterising this type.

You can retrieve the information about a type or property under the URL https://schema.org/ followed by the type name
(e.g. https://schema.org/Person) or property name (e.g. https://schema.org/givenName).


Models
------

This extension provides model classes for each type under the PHP namespace ``\Brotkrueml\Schema\Model\Type``. For example.
the type ``Thing`` is mapped to the model ``\Brotkrueml\Schema\Model\Type\Thing``, which defines the according schema.org
properties as class properties. A model can also be part of another model.

.. code-block:: php

   $thing = new \Brotkrueml\Schema\Model\Type\Thing();
   $thing->setProperty('name', 'A thing');

The schema manager connects the type models to the page and is responsible for generating the markup on the web page.

.. code-block:: php

   $schemaManager = TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      \Brotkrueml\Schema\Manager\SchemaManager::class
   );
   $schemaManager->addType($thing);

The chapter :ref:`Using the API <api>` describes in-depth how to use the models and the schema manager.

The models were generated from the schema.org definition and will be updated as the standard evolves.


View Helpers
------------

For usage in Fluid templates, each type is mapped to a view helper in the ``schema:type`` namespace. You assign the
type properties as view helper arguments, e.g.:

.. code-block:: html

    <schema:type.thing name="A thing"/>

The view helpers can be nested into each other.

The chapter :ref:`Using the View Helpers <view-helpers>` explains the usage of the view helpers.

The view helpers were generated from the schema.org definition and will be updated as the standard evolves.
