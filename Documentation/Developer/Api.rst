.. include:: ../Includes.txt

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

Starting With An Example
========================

Let's start with a simple example. Imagine you describe a
`person <https://schema.org/Person>`__ on a plugin's detail page that you want
to enrich with structured markup. First you have to create the schema model::

   $person = new \Brotkrueml\Schema\Model\Type\Person();

As you see, the schema type ``Person`` maps to the model :php:`Person`. You can
use every accepted type of the
`schema.org vocabulary <https://schema.org/docs/full.html>`__.

Surely you will need to add some properties::

   $person
      ->setId('http://example.org/#person-42')
      ->setProperty('givenName', 'John')
      ->setProperty('familyName', 'Smith')
      ->setProperty('gender', 'http://schema.org/Male');
   ;

That was easy ... let's go on and define an event the person attends::

   $event = (new \Brotkrueml\Schema\Model\Type\Event())
      ->setProperty('name', 'Fancy Event')
      ->setProperty('image', 'https:/example.org/event.png')
      ->setProperty('url', 'https://example.org/')
      ->setProperty('isAccessibleForFree', true)
      ->setProperty('sameAs', 'https://twitter.com/fancy-event')
      ->addProperty('sameAs', 'https://facebook.com/fancy-event')
   ;

Now we have to connect the two types together::

   $person->setProperty('attendee', $event);

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
      "@context": "http://schema.org",
      "@type": "Person",
      "@id": "http://example.org/#person-42",
      "givenName": "John",
      "familyName": "Smith",
      "gender": "http://schema.org/Male",
      "attendee": {
         "@type": "Event",
         "name": "Fancy Event",
         "image": "https://example.org/event.png",
         "url": "https://example.org",
         "isAccessibleForFree": "http://schema.org/True",
         "sameAs": ["https://twitter.com/fancy-event", "https://facebook.com/fancy-event"]
      }
   }

.. index::
   single: Model API
   seealso: Model API; API
   seealso: Model API; Model

The Model In-Depth
==================

Available Type Model Methods
----------------------------

The type models expose several methods:

:php:`->setId(string $id)`
~~~~~~~~~~~~~~~~~~~~~~~~~~

The method sets the unique ID of the model. With the ID, you can cross-reference
types on the same page or between different pages (and even between different
web sites) without repeating all the properties.

It is common to use an
`IRI <https://en.wikipedia.org/wiki/Internationalized_Resource_Identifier>`__ as
ID like in the above example. Please keep in mind that the ID should be
consistent between changes of the properties, e.g. if a person marries and the
name is changed. The person is still the same, so the IRI should be.

The IRI is no URL, so it is acceptable to give a "404 Not Found" back if you
call it in a browser.

Parameter
   :php:`string $id`: The unique id to set.

Return value
   Reference to the model itself.


:php:`->getId()`
~~~~~~~~~~~~~~~~

Gets the id of the type model.

Parameter
   none

Return value
   A previously set id or null (if not defined).


:php:`->setProperty(string $propertyName, $propertyValue)`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Call this method to set a property or overwrite a previously one.

Parameters
   :php:`string $propertyName`
      The property name to set. If the property does not exist in the model,
      an exception is thrown.
   :php:`string|array|bool|AbstractType|null $propertyValue`
      The value of the property to set. This can be a string, a boolean, another
      model or an array of strings, booleans or models. Also null is possible to
      clear the property value.

Return value
   Reference to the model itself.


:php:`->addProperty(string $propertyName, $propertyValue)`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

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
   :php:`string|array|bool|AbstractType|null $propertyValue`
      The value of the property to set. This can be a string, a boolean, another
      model or an array of strings, booleans or models. Also null is possible to
      clear the property value.

Return value
   Reference to the model itself.


:php:`->setProperties(array $properties)`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Set multiple properties at once.

Parameter
   :php:`array $properties`
      The properties to set. The key of the array is the property name, the
      value is the property value. Allowed as values are the same as with the
      method :php:`->setProperty()`.

Return value
   Reference to the model itself.


:php:`->getProperty(string $propertyName)`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Get the value of a property.

Parameter
   :php:`string $propertyName`
      The property name to get the value from. If the property name does not
      exist in the model, an exception is thrown.

Return value
   The value of the property (string, bool, model, array of strings, array of
   models, null).


:php:`->hasProperty(string $propertyName)`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Check whether the property name exists in a particular model.

Parameter
   :php:`string $propertyName`
      The property name to check.

Return value
   :php:`true`, if the property exists and :php:`false`, otherwise.


:php:`->clearProperty(string $propertyName)`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Resets the value of the property (set it to :php:`null`).

Parameter
   :php:`string $propertyName`
      The property name to set. If the property does not exist in the model, an
      exception is thrown.

Return value
   Reference to the model itself.


:php:`->getPropertyNames()`
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Get the names of all properties of the model.

Return value
   Array of all property names of the model.


:php:`->isEmpty()`
~~~~~~~~~~~~~~~~~~

Checks, whether all properties of the models are empty.

Parameter
   none

Return value
   :php:`true` if all properties have an empty value, :php:`false` otherwise.

   .. note::
      If at least one property has a boolean value, the method :php:`isEmpty()`
      returns false, because it is mapped on the type
      ``http://schema.org/False`` or ``http://schema.org/True``.


Other Useful APIs
=================

.. index::
   single: Boolean

Boolean Data Type
-----------------

Boolean property values are mapped to the according schema terms
``http://schema.org/True`` or ``http://schema.org/False``. You can also use
the :php:`Brotkrueml\Schema\Model\DataType\Boolean` class yourself. It exposes
two public constants:

:php:`::FALSE`
   Has the value ``http://schema.org/False``.

:php:`::TRUE`
   Has the value ``http://schema.org/True``.

and one static method:

:php:`::convertToTerm(bool $value): string`
   This method returns the according schema term.


.. index::
   single: Type list
   seealso: Type list; API

List Of Types
-------------

If you need a list of the available types or a subset of them, you can call
methods on the :php:`Brotkrueml\Schema\Registry\TypeRegistry` class. As this is
a singleton, instantiate the class with::

   $typeRegistry = GeneralUtility::makeInstance(\Brotkrueml\Schema\Registry\TypeRegistry::class);

or use dependency injection in TYPO3 v10+.


:php:`->getTypes()`
~~~~~~~~~~~~~~~~~~~

Get all available type names.

Parameter
   none

Return value
   Array, sorted alphabetically by type name.


:php:`->getWebPageTypes()`
~~~~~~~~~~~~~~~~~~~~~~~~~~

Get the `WebPage <https://schema.org/WebPage>`__ type and its descendants.

Parameter
   none

Return value
   Array, sorted alphabetically by type name.


:php:`->getWebPageElementTypes()`
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Get the `WebPageElement <https://schema.org/WebPageElement>`__ type and its
descendants.

Parameter
   none

Return value
   Array, sorted alphabetically by type name.


.. _api-typesprovider-getcontenttypes:

:php:`->getContentTypes()`
~~~~~~~~~~~~~~~~~~~~~~~~~~

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
