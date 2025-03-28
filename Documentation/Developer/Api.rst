.. include:: /Includes.rst.txt

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

Each type model class in the PHP namespace :php:`\Brotkrueml\Schema\Model\Type`
inherits from the abstract class
:php:`\Brotkrueml\Schema\Core\Model\AbstractType` which defines methods to set
and get the properties of a model.

There are currently over 600 models available.

Starting with examples
======================

.. _types:

Types
-----

.. deprecated:: 3.0.0
   Before version 3.0 a type was created with the static method
   :php:`TypeFactory::createType()`. This has been
   :ref:`deprecated <api-deprecations>`, inject the :php:`TypeFactory` into the
   constructor and use :php:`TypeFactory->create()` instead (like in the example
   below).

Let's start with a simple example. Imagine you describe a `person`_ on a
plugin's detail page that you want to enrich with structured markup. First you
have to create the schema model:

.. literalinclude:: _Api/_MyController1.php
   :language: php
   :caption: EXT:my_extension/Classes/Controller/MyController.php
   :emphasize-lines: 11-14,20

The schema type `Person` maps to the model
:php:`\Brotkrueml\Schema\Model\Type\Person`. You can use every accepted type
from the core section of `schema.org`_. Also have a look into the
:file:`Classes\Model\Type` folder of this extension to get a general idea
of the available types.

If the type is not available a :php:`\DomainException` is thrown.

Every type implements the :php:`\Brotkrueml\Schema\Core\Model\TypeInterface`.
You will find a list of the available methods in the section
:ref:`Available type model methods <api-type-interface>`.

Surely you will need to add some properties:

.. literalinclude:: _Api/_MyController2.php
   :language: php
   :caption: EXT:my_extension/Classes/Controller/MyController.php
   :emphasize-lines: 20-25

That was easy ...

.. versionadded:: 3.9.0
   The example above makes use of the `GenderType` enumeration. See
   :ref:`enumerations <enumerations>` for more details.

Let's go on and define an event the person attends:

.. literalinclude:: _Api/_MyController3.php
   :language: php
   :caption: EXT:my_extension/Classes/Controller/MyController.php
   :emphasize-lines: 20-27

Now we have to connect the two types together:

.. literalinclude:: _Api/_MyController4.php
   :language: php
   :caption: EXT:my_extension/Classes/Controller/MyController.php
   :emphasize-lines: 25

The defined models are ready to embed on the web page. The schema manager does
that for you:

.. literalinclude:: _Api/_MyController5.php
   :language: php
   :caption: EXT:my_extension/Classes/Controller/MyController.php
   :emphasize-lines: 13,26


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
         "sameAs": ["https://mastodon.social/@fancy-event", "https://pixelfed.social/@fancy-event"]
      }
   }


.. _multiple-types:

Multiple types
--------------

JSON-LD allows multiple types for a node. The rendered `@type` property is then
an array, the properties of the single types are merged. This way, a node can
be, for example, a `Product` and a `Service` at the same time - which can be
useful in some cases.

The technical difference to a single type is only that you call
:php:`\Brotkrueml\Schema\Type\TypeFactory->create()` with more than one
argument:

.. literalinclude:: _Api/_MyControllerMultiple.php
   :language: php
   :caption: EXT:my_extension/Classes/Controller/MyController.php
   :emphasize-lines: 22-29

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


.. _node-identifier:

Node identifiers
----------------

JSON-LD supports the usage of `@id` as reference without giving a type. This is
useful when using circular references, for example:

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
:php:`\Brotkrueml\Schema\Core\Model\NodeIdentifier` class:

.. literalinclude:: _Api/_MyControllerNodeIdentifier.php
   :language: php
   :caption: EXT:my_extension/Classes/Controller/MyController.php
   :emphasize-lines: 23-37

As you can see in the example, you can also use a node identifier as an
argument for :php:`->setId()` instead of a string.


.. _blank-node-identifier:

Blank node identifiers
----------------------

Sometimes it is not necessary (or possible) to define a globally unique ID
with an IRI. For these cases you can use a `blank node identifier`_.

The above example can also be used with a blank node identifier:

.. literalinclude:: _Api/_MyControllerBlankNodeIdentifier.php
   :language: php
   :caption: EXT:my_extension/Classes/Controller/MyController.php
   :emphasize-lines: 23-36

To use a blank node identifier instantiate the class
:php:`\Brotkrueml\Schema\Core\Model\BlankNodeIdentifier`. The identifier is
generated automatically on instantiation, so you do not have to worry about
the ID itself. A blank node identifier in JSON-LD always starts with `_:`.

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


The model in-depth
==================

Each type model, like `Thing`, `Person` or `Event`, must implement the
interfaces :php:`\Brotkrueml\Schema\Core\Model\NodeIdentifierInterface` and
:php:`\Brotkrueml\Schema\Core\Model\TypeInterface`. For convenience, a type
model can also extend the abstract class
:php:`\Brotkrueml\Schema\Core\Model\AbstractType` which implements every
required method.

Each :ref:`enumeration type <enumerations>`, like `GenderType`,
`ItemAvailability` or `OrderStatus`, implement the interface
:php:`\Brotkrueml\Schema\Core\Model\EnumerationInterface`.

One interface is available to "mark" a type model class as a "special type". It
does not require the implementation of additional methods:

*  :php:`\Brotkrueml\Schema\Core\Model\WebPageTypeInterface` for a
   :ref:`web page type <webpage-types>`.

These interfaces can be useful when you want to
:ref:`extend the vocabulary <extending-vocabulary>`.

.. uml::
   :caption: Inheritance of the type models (namespaces are omitted for better readability)

   object Thing
   object Event
   object OtherTypes
   object WebPage
   object Enumeration
   abstract AbstractType
   interface NodeIdentifierInterface
   interface TypeInterface
   interface WebPageTypeInterface
   interface EnumerationInterface

   Thing --|> AbstractType
   Event --|> AbstractType
   OtherTypes --|> AbstractType
   WebPage --|> AbstractType
   AbstractType --|> TypeInterface
   TypeInterface --|> NodeIdentifierInterface
   WebPage --|> WebPageTypeInterface
   Enumeration --|> EnumerationInterface

Each type model delivered with this extension extends the :php:`AbstractType`
class.


.. _api-type-interface:

Available type model methods
----------------------------

The type models which implement :php:`\Brotkrueml\Schema\Core\Model\TypeInterface`
or extend :php:`\Brotkrueml\Schema\Core\Model\AbstractType` expose the following
methods:

.. confval:: setId($id): static
   :name: abstracttype-setid

   The method sets the unique ID of the model. With the ID, you can
   cross-reference types on the same page or between different pages (and even
   between different web sites) without repeating all the properties.

   It is common to use an `IRI`_ as ID like in the above example. Please keep in
   mind that the ID should be consistent between changes of the properties, for
   example, if a person marries and the name is changed. The person is still the
   same, so the IRI should be.

   The IRI is no URL, so it is acceptable to give a "404 Not Found" back if you
   call it in a browser.

   Parameter
      :php:`NodeIdentifierInterface|string|null $id`: The unique ID to set.

   Return value
      Reference to the model itself.


.. confval:: getId(): string|null
   :name: abstracttype-getid

   Gets the ID of the type model.

   Parameter
      none

   Return value
      A previously set ID or null (if not defined).


.. confval:: setProperty($propertyName, $propertyValue): static
   :name: abstracttype-setproperty

   Call this method to set a property or overwrite a previously one.

   Parameters
      :php:`string $propertyName`
         The property name to set. If the property does not exist in the model,
         an exception is thrown.
      :php:`string|array|bool|TypeInterface|NodeIdentifierInterface|null $propertyValue`
         The value of the property to set. This can be a string, a boolean,
         another model, a node identifier or an array of strings, booleans or
         models. Also null is possible to clear the property value.

   Return value
      Reference to the model itself.


.. confval:: addProperty($propertyName, $propertyValue): static
   :name: abstracttype-addproperty

   Call this method if you want to add a value to an existing one. In the
   example above, you can see that :php:`addProperty()` is used to add a second
   value to the :php:`sameAs` property.

   Calling the :php:`addProperty()` method on a property that has no value
   assigned has the same effect as calling :php:`setProperty()`. So you can
   safely use it, for example, in a loop, to set some values on a property.

   Parameters
      :php:`string $propertyName`
         The property name to set. If the property does not exist in the model,
         an exception is thrown.
      :php:`string|array|bool|TypeInterface|NodeIdentifierInterface|null $propertyValue`
         The value of the property to set. This can be a string, a boolean,
         another model, a node identifier or an array of strings, booleans or
         models. Also null is possible to clear the property value.

   Return value
      Reference to the model itself.


.. confval:: setProperties($properties): static
   :name: abstracttype-setproperties

   Set multiple properties at once.

   Parameter
      :php:`array $properties`
         The properties to set. The key of the array is the property name, the
         value is the property value. Allowed as values are the same as with the
         method :php:`->setProperty()`.

   Return value
      Reference to the model itself.


.. confval:: getProperty($propertyName): mixed
   :name: abstracttype-getproperty

   Get the value of a property.

   Parameter
      :php:`string $propertyName`
         The property name to get the value from. If the property name does not
         exist in the model, an exception is thrown.

   Return value
      The value of the property (string, bool, model, node identifier, array of
      strings, array of models, null).


.. confval:: hasProperty($propertyName): bool
   :name: abstracttype-hasproperty

   Check whether the property name exists in a particular model.

   Parameter
      :php:`string $propertyName`
         The property name to check.

   Return value
      :php:`true`, if the property exists and :php:`false`, otherwise.


.. confval:: clearProperty($propertyName): static
   :name: abstracttype-clearproperty

   Resets the value of the property (set it to :php:`null`).

   Parameter
      :php:`string $propertyName`
         The property name to set. If the property does not exist in the model,
         an exception is thrown.

   Return value
      Reference to the model itself.


.. confval:: getPropertyNames(): array
   :name: abstracttype-getpropertynames

   Get the names of all properties of the model.

   Return value
      Array of all property names of the model.


.. confval:: getType(): string|string[]
   :name: abstracttype-gettype

   Get the type of the model.

   Return value
      A string (if it is a single type) or an array of strings (if it is a
      :ref:`multiple type <multiple-types>`).


.. _api-enumeration-interface:

:php:`EnumerationInterface` method
----------------------------------

An :ref:`enumeration type <enumerations>` requires to implement the interface
:php:`\Brotkrueml\Schema\Core\Model\EnumerationInterface`.

.. confval:: canonical(): string
   :name: enumerationinterface-canonical

   Returns the canonical value of an enum case. This value is used for
   JSON-LD rendering.

   Return value
      The canonical value.


.. _api-schema-manager:

Schema manager
==============

The schema manager (class :php:`\Brotkrueml\Schema\Manager\SchemaManager`)
collects the concrete type model objects and prepares them for embedding into
the web page.

The class exposes the following methods:

.. confval:: addType(...$type): self
   :name: schemamanager-addtype

   .. versionadded:: 3.9.0
      This method is now variadic and can take an arbitrary number of type
      models.

   Adds the given type models to the Schema Manager for inclusion on the web
   page.

   Parameter
      :php:`TypeInterface ...$type`
         The type model classes with the set properties. These can be also
         "special" types, like a `WebPage` or a `BreadcrumbList`.

   Return value
      Reference to itself.


.. confval:: hasWebPage(); bool
   :name: schemamanager-haswebpage

   Checks, if a :ref:`web page type <webpage-types>` is already available.

   Parameter
      none

   Return value
      :php:`true`, if a web page type is available, otherwise :php:`false`.


.. _api-schema-manager-addmainentityofwebpage:

.. confval:: addMainEntityOfWebPage($mainEntity, $isPrioritised = false): self
   :name: schemamanager-addmainentityofwebpage

   Adds a :ref:`main entity <main-entity-of-web-page>` to the web page.

   Parameters
      :php:`TypeInterface $mainEntity`
         The type model to be added.

      :php:`bool $isPrioritised`
            Set to :php:`true` to :ref:`prioritise <main-entity-prioritisation>`
            a main entity.

   Return value
      Reference to itself.


.. _api-node-identifier:

Node identifier
===============

A node identifier (class :php:`\Brotkrueml\Schema\Core\Model\NodeIdentifier`)
holds the ID for a type or a reference.

On instantiation of a NodeIdentifier the ID is given as a string argument into
the constructor.

The class exposes the following method:

.. confval:: getId(): string
   :name: nodeidentifier-getid

   Returns the ID.

   Parameter
      none

   Return value
      The ID as a string.


.. _api-blank-node-identifier:

Blank node identifier
=====================

A blank node identifier (class :php:`\Brotkrueml\Schema\Core\Model\BlankNodeIdentifier`)
holds the ID for a type or a reference.

On instantiation of a BlankNodeIdentifier the ID is auto-generated and unique
within a request.

The class exposes the following method:

.. confval:: getId(): string
   :name: blanknodeidentifier-getid

   Returns the ID.

   Parameter
      none

   Return value
      The ID as a string.



Other useful APIs
=================

Boolean data type
-----------------

Boolean property values are mapped to the according schema terms
`https://schema.org/True` or `https://schema.org/False`. You can also use
the :php:`\Brotkrueml\Schema\Model\DataType\Boolean` class yourself. It exposes
two public constants:

.. confval:: FALSE
   :name: boolean-false

   Provides the value `https://schema.org/False`.

.. confval:: TRUE
   :name: boolean-true

   Provides the value `https://schema.org/True`.

and one static method:

.. confval:: convertToTerm(bool $value): string
   :name: boolean-converttoterm

   This method returns the according schema term.


.. _blank node identifier: https://www.w3.org/TR/json-ld11/#example-95-referencing-an-unidentified-node
.. _person: https://schema.org/Person
.. _IRI: https://en.wikipedia.org/wiki/Internationalized_Resource_Identifier
.. _schema.org: https://schema.org/docs/full.html
.. _web page element type: https://schema.org/WebPageElement
.. _WebPage: https://schema.org/WebPage
.. _WebPageElement: https://schema.org/WebPageElement
