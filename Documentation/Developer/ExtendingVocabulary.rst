.. include:: /Includes.rst.txt

.. _extending-vocabulary:

========================
Extending the vocabulary
========================

Target group: **Developers**

.. contents:: Table of Contents
   :depth: 1
   :local:


Introduction
============

The TYPO3 schema extension ships :ref:`type models <api>` and :ref:`view helpers
<view-helpers>` with their properties from the core section of the schema.org
definitions. However, there are several extensions, like
`Health and lifesciences`_ or `Autos`_. There are also `pending types and
properties`_ available that enable schema.org to introduce terms on an
experimental basis.

The embedding of these vocabulary extensions goes beyond the scope of this TYPO3
extension, as it will considerably increase the number of terms – while most of
them are not used by the majority of users.

For your convenience there are separate extensions to :ref:`extend the
vocabulary <vocabulary>` available with the terms of the different sections. But
if you only want to add only a few terms you are encouraged to add them on your
own, especially pending terms.

Pending terms are experimental, after a certain time a term will be incorporated
into the core section or dropped. This depends on the usage, adoption and
discussions. To maintain backward-compatibility and to not break any pages,
pending types are also not supplied by this extension.

But the vocabulary delivered with this extension can be extended according to
your needs. This chapter describes the necessary steps to register additional
properties to existing types or to introduce new types on your website.


.. _extending-register-additional-properties:

Register additional properties
==============================

Sometimes it may be necessary to use properties that are not standardised or
`pending`_, or to add `property annotations`_. Therefore the schema extension
provides a way to extend types.

These additional properties are not only available in the :ref:`API <api>` but
also as arguments in the :ref:`view helpers <view-helpers>`.

To add one or more properties to a type, create a new class, for example in
:file:`EXT:my_extension/Classes/Schema/AdditionalProperties/` and implement
the `\Brotkrueml\Schema\Core\AdditionalPropertiesInterface`. The interface
requires two methods:

.. confval:: getType(): string
   :name: additional-properties-interface-get-type

   Returns the type name.

.. confval:: getAdditionalProperties(): array
   :name: additional-properties-interface-get-additional-properties

   Return a list of additional properties as string.

Here is an example for such an implementation:

.. literalinclude:: _ExtendingVocabulary/_Car.php
   :language: php
   :caption: EXT:my_extension/Classes/Schema/AdditionalProperties/Car.php

For each type create a new PHP class.

.. important::
   Flush the cache after a change via the console or
   :guilabel:`Admin Tools > Maintenance`.

.. note::
   About 1-2 times a year a new version of the schema.org definition is
   `released`_. The extension adopts these changes in future releases. If you
   register a pending property for a type, this property can be included in the
   core section in a later version of this extension. However, it doesn't do
   any harm to register a property that already exists.


.. _extending-adding-types:

Adding types
============

.. versionchanged:: 3.0.0

You can add additional types for use in the :ref:`API <api>` or as a
:ref:`WebPage type <webpage-types>`. As an example, in March 2020, schema.org
introduces a new `VirtualLocation`_ type related to the corona crisis, which
was quickly adopted by Google. The type can be used as `location`_ in the
`Event`_ type. So let's start with this example.

.. rst-class:: bignums-xxl

#. Create the type model class

   The model class for a type defines the available properties. The model class
   for the `VirtualLocation` type may look like the following:

   .. literalinclude:: _ExtendingVocabulary/_VirtualLocation.php
      :language: php
      :caption: EXT:my_extension/Classes/Schema/Type/VirtualLocation.php

   In the example, the class is stored in :file:`Classes/Schema/Type` of your
   extension, but you can choose any namespace. It has to extend from
   :php:`\Brotkrueml\Schema\Core\Model\AbstractType`. The class must have the
   :php:`\Brotkrueml\Schema\Attributes\Type` attribute assigned. It has one
   mandatory parameter: the type name. The protected static property
   :php:`$propertyNames` contains the available schema.org properties.

   Now you can use the `VirtualLocation` in your PHP code:

   .. literalinclude:: _ExtendingVocabulary/_MyController.php
      :language: php
      :caption: EXT:my_extension/Classes/Controller/MyController.php
      :emphasize-lines: 21-23

   .. note::
      With the :php:`\Brotkrueml\Schema\Attributes\Type` attribute the class
      is recognised as a type model class. All types are collected on
      :abbr:`DI (dependency injection)` compile time: When you add/change/remove
      a class, you have to flush the cache via
      :guilabel:`Admin Tools > Maintenance` or the :bash:`flush:cache` command
      on :ref:`CLI <t3coreapi:symfony-console-commands>`.

#. Create the view helper (optional)

   If you have the need for a view helper with that type, you can create one:

   .. literalinclude:: _ExtendingVocabulary/_VirtualLocationViewHelper.php
      :language: php
      :caption: EXT:my_extension/Classes/ViewHelpers/Schema/Type/VirtualLocationViewHelper.php

   .. versionchanged:: 3.0
      The name of the type must be defined with the :php:`$type` property.

   To use the `schema` namespace in Fluid templates also with your custom
   view helpers add the following snippet to the :file:`ext_localconf.php` file
   of your extension:

   .. code-block:: php
      :caption: EXT:my_extension/ext_localconf.php

      $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['schema'][]
         = 'MyVendor\\MyExtension\\ViewHelpers\\Schema';

   This way you don't have to think about which namespace to use. And if the
   pending type is moved to the core section you have no need to touch your
   Fluid templates. Of course, feel free to use another namespace.

.. attention::
   Add the schema extension as a dependency to your extension. This ensures that
   your class models take precedence over the delivered models from the schema
   extension. This may be necessary, if you define a pending type with pending
   properties (which you also use) to avoid breaks when the type is included
   into the core section but some properties aren't.

.. tip::
   Have a look into the `schema_virtuallocation`_ extension. It serves as a
   blueprint for adding own types and view helpers.


Add a new WebPage type
======================

.. versionchanged:: 3.0.0

If you are responsible for a medical website, the chances are high that you need
the `MedicalWebPage`_ web page type, which is part of the Health schema.org
extension.

Register this web page type so that it is available in the :ref:`web page type
list <webpage-types-list>` in the page properties. Simply follow the steps in
the :ref:`extending-adding-types` section.

Mark your class as a WebPage type with the interface
:php:`\Brotkrueml\Schema\Core\Model\WebPageTypeInterface`:

.. literalinclude:: _ExtendingVocabulary/_MedicalWebPage.php
   :language: php
   :caption: EXT:my_extension/Classes/Schema/Type/MedicalWebPage.php

The new web page type can now be selected in the page properties:

.. figure:: /Images/Developer/MedicalWebPageTypeSelection.png
   :alt: MedicalWebPage in the list of available web page types

   *MedicalWebPage* in the list of available web page types


.. _extending-adding-enumeration:

Add a new enumeration
=====================

schema.org provides the ability to use enumerations as values for certain
properties. The TYPO3 schema extensions provide the
:ref:`enumerations <enumerations>` defined by schema.org. However, there are
some enumerations where schema.org refers to other vocabularies. These
enumerations are not provided by the TYPO3 schema extensions.
An example is `BusinessEntityType`_, which suggests using the `GoodRelations`_
terms. If you want to use them, you can define and use your own enumeration to
provide a defined set of of possible values satisfiying your needs (instead of
plain strings):

.. literalinclude:: _ExtendingVocabulary/_BusinessEntityType.php
   :language: php
   :caption: EXT:my_extension/Classes/Schema/Enumeration/BusinessEntityType.php

All enumeration types must implement the interface
:ref:`Brotkrueml\\Schema\\Core\\Model\\EnumerationInterface <api-enumeration-interface>`,
which requires a :php:`canonical()` method. Depending on the case, it returns
the string to use in the JSON-LD output.

Now you can make use of this enum in PHP, for example:

.. code-block:: php

   // use MyVendor\MyExtension\Schema\Enumeration\BusinessEntityType;

   $demand = $this->typeFactory->create('Demand');
   $demand->setProperty('eligibleCustomerType', BusinessEntityType::Enduser);

or in :ref:`Fluid <enumerations-view-helper>`:

.. code-block:: html

   <schema:type.demand
      eligibleCustomerType="{f:constant(
         name: \MyVendor\MyExtension\Schema\Enumeration\BusinessEntityType::Enduser
      )}"
   />

which results in:

.. code-block:: json

   {
      "@type": "Demand",
      "eligibleCustomerType": "http://purl.org/goodrelations/v1#Enduser"
   }

Another use case might be to create your own extended `GenderType`
enum instead using the enum from this extension:

.. literalinclude:: _ExtendingVocabulary/_GenderType.php
   :language: php
   :caption: EXT:my_extension/Classes/Schema/Enumeration/GenderType.php


.. _Autos: https://schema.org/docs/automotive.html
.. _BusinessEntityType: https://schema.org/BusinessEntityType
.. _Event: https://schema.org/Event
.. _GoodRelations: http://www.heppnetz.de/ontologies/goodrelations/v1
.. _Health and lifesciences: https://schema.org/docs/meddocs.html
.. _location: https://schema.org/location
.. _MedicalWebPage: https://schema.org/MedicalWebPage
.. _pending: https://pending.schema.org/
.. _pending types and properties: https://pending.schema.org/docs/pending.home.html
.. _property annotations: https://schema.org/docs/actions.html#part-4
.. _released: https://schema.org/docs/releases.html
.. _schema_virtuallocation: https://github.com/brotkrueml/schema-virtuallocation
.. _VirtualLocation: https://schema.org/VirtualLocation
