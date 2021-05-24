.. include:: /Includes.rst.txt

.. index:: API

.. _api:

=============
Using The API
=============

Target group: **Developers**

.. contents:: Table of Contents
   :depth: 3
   :local:


Introduction
============

With the extension's API you can define the structured markup with PHP. For
example, create a class which gets an Extbase model as input and defines the
markup. Then instantiate the class in an action of your controller.

Each type model class in the PHP namespace :php:`Brotkrueml\Schema\Model\Type`
inherits from the abstract class
:php:`Brotkrueml\Schema\Core\Model\AbstractType` which defines methods to set
and get the properties of a model.

There are currently over 600 models available.

Starting with examples
======================

.. index:: Type

.. _types:

Types
-----

Let's start with a simple example. Imagine you describe a
`person <https://schema.org/Person>`_ on a plugin's detail page that you want
to enrich with structured markup. First you have to create the schema model::

   $person = \Brotkrueml\Schema\Type\TypeFactory::createType('Person')

The schema type ``Person`` maps to the model :php:`Person`. You can
use every accepted type from the core vocabulary from `schema.org
<https://schema.org/docs/full.html>`_. Also have a look into the
:file:`Classes\Model\Type` folder of this extension to get a general idea of the
available types.

If the type is not available a :php:`\DomainException` is thrown.

Every type implements the :php:`\Brotkrueml\Schema\Core\Model\TypeInterface`.
You will find a list of the available methods in the section
:ref:`Available type model methods <api-type-interface>`.

Surely you will need to add some properties::

   $person
      ->setId('https://example.org/#person-42')
      ->setProperty('givenName', 'John')
      ->setProperty('familyName', 'Smith')
      ->setProperty('gender', 'https://schema.org/Male');
   ;

That was easy ... let's go on and define an event the person attends::

   $event = \Brotkrueml\Schema\Type\TypeFactory::createType('Event')
      ->setProperty('name', 'Fancy Event')
      ->setProperty('image', 'https:/example.org/event.png')
      ->setProperty('url', 'https://example.org/')
      ->setProperty('isAccessibleForFree', true)
      ->setProperty('sameAs', 'https://twitter.com/fancy-event')
      ->addProperty('sameAs', 'https://facebook.com/fancy-event')
   ;

Now we have to connect the two types together::

   $person->setProperty('performerIn', $event);

The defined models are ready to embed on the web page. The schema manager does
that for you::

   $schemaManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      \Brotkrueml\Schema\Manager\SchemaManager::class
   );
   $schemaManager->addType($person);


That's it ... if you call the according page the structured markup is embedded
automatically into the head section:

.. code-block:: json

   {
      "@context": "https://schema.org/",
      "@type": "Person",
      "@id": "https://example.org/#person-42",
      "givenName": "John",
      "familyName": "Smith",
      "gender": "https://schema.org/Male",
      "performerIn": {
         "@type": "Event",
         "name": "Fancy Event",
         "image": "https://example.org/event.png",
         "url": "https://example.org",
         "isAccessibleForFree": "https://schema.org/True",
         "sameAs": ["https://twitter.com/fancy-event", "https://facebook.com/fancy-event"]
      }
   }


.. index:: Multiple type

.. _multiple-types:

Multiple types
--------------

JSON-LD allows multiple types for a node. The rendered `@type` property is then
an array, the properties of the single types are merged. This way, a node can
be, e.g., a `Product` and a `Service` at the same time - which can be useful
in some cases.

The difference to a single type is only that you call
:php:`\Brotkrueml\Schema\Type\TypeFactory::createType()` with more than one
argument::

   $productAndService = \Brotkrueml\Schema\Type\TypeFactory::createType('Product', 'Service');
   $productAndService
      ->setId('https://example.org/#my-product-and-service')
      ->setProperty('name', 'My product and service')
      ->setProperty('manufacturer', 'Acme Ltd.') // from Product
      ->setProperty('provider', 'Acme Ltd.') // from Service
   ;
   $schemaManager->addType($productAndService);

The factory method returns an instance of the
:php:`\Brotkrueml\Schema\Core\Model\MultipleType` class which provides the
same API as a single type.

This results in the following JSON-LD:

.. code-block:: json

   {
      "@context": "https://schema.org/",
      "@type": ["Product", "Service"],
      "@id": "https://example.org/#my-product-and-service",
      "manufacturer": "Acme Ltd.",
      "name": "My product and service",
      "provider": "Acme Ltd."
   }


.. index::
   single: Node identifier

.. node-identifier::

Node identifiers
----------------

JSON-LD supports the usage of `@id` as reference without giving a type. This is
useful when using circular references, e.g.:

.. code-block:: json

   {
      "@context": "https://schema.org/",
      "@type": "Person",
      "@id": "https://example.org/#john-smith",
      "name": "John Smith",
      "knows": {
         "@type": "Person",
         "name": "Sarah Jane Smith",
         "knows": { "@id": "https://example.org/#john-smith" }
      }
   }

You can accomplish this with the help of the
:php:`Brotkrueml\Schema\Core\Model\NodeIdentifier` class::

   $nodeIdentifier = new Brotkrueml\Schema\Core\Model\NodeIdentifier(
      'https://example.org/#john-smith'
   );

   $person1 = \Brotkrueml\Schema\Type\TypeFactory::createType('Person');
   $person1->setId($nodeIdentifier);
   $person1->setProperty('name', 'John Smith');

   $person2 = \Brotkrueml\Schema\Type\TypeFactory::createType('Person');
   $person2->setProperty('name', 'Sarah Jane Smith');
   $person2->setProperty('knows', $nodeIdentifier);

   $person1->setProperty('knows', $person2);

As you can see in the example, you can also user a node identifier as an
argument for :php:`->setId()` instead of a string.


.. index::
   single: Blank node identifier

.. blank-node-identifier::

Blank node identifiers
----------------------

Sometimes it is not necessary (or possible) to define a globally unique ID
with an IRI. For these cases you can use a `blank node identifier
<https://www.w3.org/TR/json-ld11/#example-95-referencing-an-unidentified-node>`_.

The above example can also be used with a blank node identifier::

   $nodeIdentifier = new Brotkrueml\Schema\Core\Model\BlankNodeIdentifier();

   $person1 = \Brotkrueml\Schema\Type\TypeFactory::createType('Person');
   $person1->setId($nodeIdentifier);
   $person1->setProperty('name', 'John Smith');

   $person2 = \Brotkrueml\Schema\Type\TypeFactory::createType('Person');
   $person2->setProperty('name', 'Sarah Jane Smith');
   $person2->setProperty('knows', $nodeIdentifier);

   $person1->setProperty('knows', $person2);

To use a blank node identifier just instantiate the class
:php:`Brotkrueml\Schema\Core\Model\BlankNodeIdentifier`. The identifier is
generated automatically on instantiation, so you don't have to worry about
the id itself. A blank node identifier in JSON-LD always starts with `_:`.

This results in the following JSON-LD output:

.. code-block:: json

   {
      "@context": "https://schema.org/",
      "@type": "Person",
      "@id": "_:b0",
      "name": "John Smith",
      "knows": {
         "@type": "Person",
         "name": "Sarah Jane Smith",
         "knows": { "@id": "_:b0" }
      }
   }


.. index::
   single: Model API
   seealso: Model API; API
   seealso: Model API; Model

The model in-depth
==================

Each type model, like `Thing`, `Person` or `Event`, must implement the
interfaces :php:`Brotkrueml\Schema\Core\Model\NodeIdentifierInterface` and
:php:`Brotkrueml\Schema\Core\Model\TypeInterface`. For convenience, a type
model can also extend the abstract class
:php:`Brotkrueml\Schema\Core\Model\AbstractType` which implements every needed
method.

Two other interfaces are available, they are used to "mark" a type model class as
a "special type" and don't require the implementation of additional methods:

- :php:`Brotkrueml\Schema\Core\Model\WebPageTypeInterface` for a
  :ref:`web page type <webpage-types>`.
- :php:`Brotkrueml\Schema\Core\Model\WebPageElementTypeInterface` for a
  `web page element type <https://schema.org/WebPageElement>`_.

These interfaces can be useful when you want to :ref:`extend the
vocabulary <extending-vocabulary>`.

.. uml::
   :caption: Inheritance of the type models (namespaces are omitted for better readability)

   interface NodeIdentifierInterface
   interface TypeInterface
   interface WebPageElementTypeInterface
   interface WebPageTypeInterface
   abstract AbstractType
   object WebPageElement
   object Thing
   object Event
   object OtherTypes
   object WebPage

   WebPageElementTypeInterface <|-- WebPageElement
   WebPageTypeInterface <|-- WebPage
   NodeIdentifierInterface <|-- AbstractType
   TypeInterface <|-- AbstractType
   AbstractType <|-- WebPageElement
   AbstractType <|-- Thing
   AbstractType <|-- Event
   AbstractType <|-- OtherTypes
   AbstractType <|-- WebPage

Each type model delivered with this extension extends the :php:`AbstractType`
class.


.. _api-type-interface:

Available type model methods
----------------------------

The type models which extend :php:`Brotkrueml\Schema\Core\Model\AbstractType`
expose the following methods:

.. option:: setId($id)

The method sets the unique ID of the model. With the ID, you can cross-reference
types on the same page or between different pages (and even between different
web sites) without repeating all the properties.

It is common to use an
`IRI <https://en.wikipedia.org/wiki/Internationalized_Resource_Identifier>`_ as
ID like in the above example. Please keep in mind that the ID should be
consistent between changes of the properties, e.g. if a person marries and the
name is changed. The person is still the same, so the IRI should be.

The IRI is no URL, so it is acceptable to give a "404 Not Found" back if you
call it in a browser.

Parameter
   :php:`NodeIdentifierInterface|string|null $id`: The unique id to set.

Return value
   Reference to the model itself.


.. option:: getId(): string|null

Gets the id of the type model.

Parameter
   none

Return value
   A previously set id or null (if not defined).


.. option:: setProperty($propertyName, $propertyValue)

Call this method to set a property or overwrite a previously one.

Parameters
   :php:`string $propertyName`
      The property name to set. If the property does not exist in the model,
      an exception is thrown.
   :php:`string|array|bool|TypeInterface|NodeIdentifierInterface|null $propertyValue`
      The value of the property to set. This can be a string, a boolean, another
      model, a node identifier or an array of strings, booleans or models. Also
      null is possible to clear the property value.

Return value
   Reference to the model itself.


.. option:: addProperty($propertyName, $propertyValue)

Call this method if you want to add a value to an existing one. In the example
above, you can see that :php:`addProperty()` is used to add a second value to
the :php:`sameAs` property.

Calling the :php:`addProperty()` method on a property that has no value assigned
has the same effect as calling :php:`setProperty()`. So you can safely use it,
e.g. in a loop, to set some values on a property.

Parameters
   :php:`string $propertyName`
      The property name to set. If the property does not exist in the model, an
      exception is thrown.
   :php:`string|array|bool|TypeInterface|NodeIdentifierInterface|null $propertyValue`
      The value of the property to set. This can be a string, a boolean, another
      model, a node identifier or an array of strings, booleans or models. Also
      null is possible to clear the property value.

Return value
   Reference to the model itself.


.. option:: setProperties($properties)

Set multiple properties at once.

Parameter
   :php:`array $properties`
      The properties to set. The key of the array is the property name, the
      value is the property value. Allowed as values are the same as with the
      method :php:`->setProperty()`.

Return value
   Reference to the model itself.


.. option:: getProperty($propertyName)

Get the value of a property.

Parameter
   :php:`string $propertyName`
      The property name to get the value from. If the property name does not
      exist in the model, an exception is thrown.

Return value
   The value of the property (string, bool, model, node identifier, array of
   strings, array of models, null).


.. option:: hasProperty($propertyName)

Check whether the property name exists in a particular model.

Parameter
   :php:`string $propertyName`
      The property name to check.

Return value
   :php:`true`, if the property exists and :php:`false`, otherwise.


.. option:: clearProperty($propertyName)

Resets the value of the property (set it to :php:`null`).

Parameter
   :php:`string $propertyName`
      The property name to set. If the property does not exist in the model, an
      exception is thrown.

Return value
   Reference to the model itself.


.. option:: getPropertyNames()

Get the names of all properties of the model.

Return value
   Array of all property names of the model.


.. option:: getType()

Get the type of the model.

Return value
   A string (if it is a single type) or an array of strings (if it is a multiple
   type).


.. index:: Schema Manager

.. _api-schema-manager:

Schema Manager
==============

The Schema Manager (class :php:`Brotkrueml\Schema\Manager\SchemaManager`) –
well – manages the type models and prepares them for embedding into the web
page.

The class exposes the following methods:

.. option:: addType($type)

Adds the given type model to the Schema Manager for inclusion on the web page.

Parameter
   :php:`TypeInterface $type`
      The type model class with the set properties. This can be also
      "special" types, like a `WebPage` or a `BreadcrumbList`.

Return value
   Reference to itself.


.. option:: hasWebPage()

Checks, if a :ref:`web page type <webpage-types>` is already available.

Parameter
   none

Return value
   :php:`true`, if a web page type is available, otherwise :php:`false`


.. _api-schema-manager-addmainentityofwebpage:

.. option:: addMainEntityOfWebPage($mainEntity)

Adds a :ref:`main entity <main-entity-of-web-page>` to the web page.

Parameter
   :php:`TypeInterface $mainEntity`
      The type model to be added.

Return value
   Reference to itself.


.. _api-node-identifier:

Node Identifier
===============

A NodeIdentifier (class :php:`Brotkrueml\Schema\Core\Model\NodeIdentifier`)
holds the ID for a type or a reference.

On instantiation of a NodeIdentifier the ID is given as a string argument into
the constructor.

The class exposes the following method:

.. option:: getId()

Returns the id.

Parameter
   none

Return value
   The id as a string.


.. _api-blank-node-identifier:

Blank Node Identifier
=====================

A BlankNodeIdentifier (class :php:`Brotkrueml\Schema\Core\Model\BlankNodeIdentifier`)
holds the ID for a type or a reference.

On instantiation of a BlankNodeIdentifier the ID is auto-generated and unique
within a request.

The class exposes the following method:

.. option:: getId()

Returns the id.

Parameter
   none

Return value
   The id as a string.



Other useful APIs
=================

.. index:: Boolean

Boolean data type
-----------------

Boolean property values are mapped to the according schema terms
``https://schema.org/True`` or ``https://schema.org/False``. You can also use
the :php:`Brotkrueml\Schema\Model\DataType\Boolean` class yourself. It exposes
two public constants:

.. option:: FALSE

Provides the value ``https://schema.org/False``.

.. option:: TRUE

Provides the value ``https://schema.org/True``.

and one static method:

.. option:: convertToTerm(bool $value): string

This method returns the according schema term.


.. index::
   single: Type list
   seealso: Type list; API

.. _api-list-of-types:

List of types
-------------

If you need a list of the available types or a subset of them, you can call
methods on the :php:`Brotkrueml\Schema\Type\TypeRegistry` class. As this is
a singleton, instantiate the class with::

   $typeRegistry = GeneralUtility::makeInstance(\Brotkrueml\Schema\Type\TypeRegistry::class);

or use dependency injection.


.. option:: getTypes()

Get all available type names.

Parameter
   none

Return value
   Array, sorted alphabetically by type name.


.. option:: getWebPageTypes()

Get the `WebPage <https://schema.org/WebPage>`__ type and its descendants.

Parameter
   none

Return value
   Array, sorted alphabetically by type name.


.. option:: getWebPageElementTypes()

Get the `WebPageElement <https://schema.org/WebPageElement>`__ type and its
descendants.

Parameter
   none

Return value
   Array, sorted alphabetically by type name.


.. option:: getContentTypes()

The types useful for an editor are returned as an array, sorted alphabetically.

The following types are filtered out:

- ``BreadcrumbList``
- ``WebPage`` and descendants
- ``WebPageElement`` and descendants
- ``WebSite``

Parameter
   none

Return value
   Array, sorted alphabetically by type name.
