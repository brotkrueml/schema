.. include:: ../../Includes.txt


.. _api:

=============
Using the API
=============

Target group: **Developers**

With the extension's API you can define the structured markup with PHP. For example, create a class which gets an
Extbase model as input and defines the markup. Then instantiate the class in an action of your controller.

Each type model class in the PHP namespace ``Brotkrueml\Schema\Model\Type`` inherits from the abstract class
``Brotkrueml\Schema\Core\Model\AbstractType`` which defines methods to set and get the properties of a model.

There are currently over 600 models available.

Starting with an Example
========================

Let's start with a simple example. Imagine you describe a `person <https://schema.org/Person>`__ on a plugin's detail
page that you want to enrich with structured markup. First you have to create the schema model:

.. code-block:: php

   $person = new \Brotkrueml\Schema\Model\Type\Person();

As you see, the schema type ``Person`` maps to the model ``Person``. You can use every accepted type of the
`schema.org vocabulary <https://schema.org/docs/full.html>`__.

Surely you will need to add some properties:

.. code-block:: php

   $person
      ->setId('http://example.org/#person-42')
      ->setProperty('givenName', 'John')
      ->setProperty('familyName', 'Smith')
      ->setProperty('gender', 'http://schema.org/Male');
   ;

That was easy ... let's go on and define the company the person works for:

.. code-block:: php

   $corporation = (new \Brotkrueml\Schema\Model\Type\Corporation())
      ->setProperty('name', 'Acme Ltd.')
      ->setProperty('image', 'https:/example.org/logo.png')
      ->setProperty('url', 'https://example.org/')
      ->setProperty('sameAs', 'https://twitter.com/acme')
      ->addProperty('sameAs', 'https://facebook.com/acme')
   ;

Now we have to connect the two types together:

.. code-block:: php

   $person->setProperty('worksFor', $corporation);

The defined models are ready to embed on the web page. The schema manager does that for you:

.. code-block:: php

   $schemaManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      \Brotkrueml\Schema\Manager\SchemaManager::class
   );
   $schemaManager->addType($person);


That's it ... if you call the according page the structured markup is embedded automatically into the head section:

.. code-block:: json

   {
      "@context": "http://schema.org",
      "@type": "Person",
      "@id": "http://example.org/#person-42",
      "givenName": "John",
      "familyName": "Smith",
      "gender": "http://schema.org/Male",
      "worksFor": {
         "@type": "Corporation",
         "name": "Acme Ltd.",
         "image": "https://example.org/logo.png",
         "url": "https://example.org",
         "sameAs": ["https://twitter.com/acme", "https://facebook.com/acme"]
      }
   }


The Model In-Depth
==================

The type models expose several methods:

->setId(string $id)
-------------------

The method sets the unique ID of the model. With the ID, you can cross-reference types on the same page or between
different pages (and even between different web sites) without repeating all the properties.

It's common to use an
``IRI <https://en.wikipedia.org/wiki/Internationalized_Resource_Identifier>``__ as ID like in the above example. Please
keep in mind that the ID should be consistent between changes of the properties, e.g. if a person marries and the name
is changed. The person is still the same, so the IRI should be.

The IRI is no URL, so it is acceptable to give a "404 Not Found" back if you call it in a browser.

Parameters:
~~~~~~~~~~~
============ ====================
Parameter    Description
============ ====================
string $id   The unique id to set
============ ====================

Return value:
~~~~~~~~~~~~~
Returns a reference to itself.


->getId()
---------

Return value:
~~~~~~~~~~~~~
A previously set id or null (if not set).


->setProperty(string $propertyName, $propertyValue)
---------------------------------------------------

You call this method to set a property or override a previously one.

Parameters:
~~~~~~~~~~~
============================================ ===========================================================================
Parameter                                    Description
============================================ ===========================================================================
string $propertyName                         The property name to set. If the property does not exist in the model, an
                                             exception is thrown.
-------------------------------------------- ---------------------------------------------------------------------------
string | array | AbstractType $propertyValue The value of the property to set. This can be a string, another model or an
                                             array of strings or models. Also null is possible to clear the property
                                             value.
============================================ ===========================================================================

Return value:
~~~~~~~~~~~~~
Returns a reference to the model itself.


->addProperty(string $propertyName, $propertyValue)
---------------------------------------------------

Call this method if you want to add a value to an existing one. In the example above, you can see that ``addProperty``
is used to add a second value to the ``sameAs`` property.

Calling the ``addProperty`` method on a property that has no value assigned has the same effect as calling
``setProperty``. So you can safely use it, e.g. in a loop, to set some values on a property.


Parameters:
~~~~~~~~~~~
============================================ ===========================================================================
Parameter                                    Description
============================================ ===========================================================================
string $propertyName                         The property name to set. If the property does not exist in the model, an
                                             exception is thrown.
-------------------------------------------- ---------------------------------------------------------------------------
string | array | AbstractType $propertyValue The value of the property to set. This can be a string, another model or an
                                             array of strings or models. Also null is possible to clear the property
                                             value.
============================================ ===========================================================================

Return value:
~~~~~~~~~~~~~
Returns a reference to the model itself.


->setProperties(array $properties)
----------------------------------

Set multiple properties at once.

Parameters:
~~~~~~~~~~~
==================== ===================================================================================================
Parameter            Description
==================== ===================================================================================================
array $properties    The properties to set. The key of the array is the property name, the value is the property value.
                     Allowed as values are the same as with the method ->setProperty().
==================== ===================================================================================================

Return value:
~~~~~~~~~~~~~
Returns a reference to the model itself.


->getProperty(string $propertyName)
-----------------------------------

Get the value of a property.

Parameters:
~~~~~~~~~~~
==================================== ===================================================================================
Parameter                            Description
==================================== ===================================================================================
string $propertyName                 The property name to get the value from. If the property name does not exist in the
                                     model, an exception is thrown.
==================================== ===================================================================================

Return value:
~~~~~~~~~~~~~
The value of the property (string, model, array of strings, array of models, null).


->hasProperty(string $propertyName)
-----------------------------------

Check whether the property name exists in a particular model.

Parameters:
~~~~~~~~~~~
==================================== ===================================================================================
Parameter                            Description
==================================== ===================================================================================
string $propertyName                 The property name to check.
==================================== ===================================================================================

Return value:
~~~~~~~~~~~~~
``true``, if the property exists and ``false``, otherwise.


->clearProperty(string $propertyName)
-------------------------------------

Resets the value of the property (set it to ``null``).

Parameters:
~~~~~~~~~~~
==================================== ===================================================================================
Parameter                            Description
==================================== ===================================================================================
string $propertyName                 The property name to set. If the property does not exist in the model, an exception
                                     is thrown.
==================================== ===================================================================================

Return value:
~~~~~~~~~~~~~
Returns a reference to the model itself.


->getPropertyNames()
--------------------

Return value:
~~~~~~~~~~~~~
Return all property names of the model in an array.


->isEmpty()
-----------

Checks, whether all properties of the models are empty.

Return value:
~~~~~~~~~~~~~
``true`` if all properties have an empty value, ``false`` otherwise.
