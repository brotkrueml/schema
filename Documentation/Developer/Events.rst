.. include:: /Includes.rst.txt

.. _events:

=============
PSR-14 events
=============

Target group: **Developers**

.. contents:: Table of Contents
   :depth: 2
   :local:

Introduction
============

You can enhance the functionality in the schema extension with PSR-14 event
listeners. An event listener receives an event that provides methods for
retrieving and setting dedicated properties.

.. seealso::
   You can find more information about PSR-14 events in the blog article
   `PSR-14 Events in TYPO3`_ and the official :ref:`TYPO3 documentation
   <t3coreapi:EventDispatcher>`.


.. _event-render-additional-types:

Render additional types
=======================

.. versionchanged:: 3.11.0
   This event is available in older versions, but is now official API.

The event allows to add markup in cases where no controller is available, for
example, if you want to enrich a page with structured data depending on the
doktype of a page.

The event :php:`\Brotkrueml\Schema\Event\RenderAdditionalTypesEvent`
provides the following methods:

.. option:: getRequest(): \Psr\Http\Message\ServerRequestInterface

   Returns the PSR-7 request object.

.. option:: addType(TypeInterface $type): void

   Add a type model.

Example
~~~~~~~

In the example we add structured data markup depending on the doktype of the
page.

.. rst-class:: bignums-xxl

#. Create the event listener

   .. literalinclude:: _Events/_AddMarkupToArticlePages.php
      :language: php
      :caption: EXT:my_extension/Classes/EventListener/AddMarkupToArticlePages.php

   The method :php:`__invoke()` implements the logic for rendering additional
   types. It receives the :php:`RenderAdditionalTypesEvent`. You can add as many
   types as you like.

#. Register your event listener in :file:`Configuration/Services.yaml`

   .. code-block:: yaml

      services:
         # Place here the default dependency injection configuration

         MyVendor\MyExtension\EventListener\AddMarkupToArticlePages:
            tags:
               - name: event.listener
                 identifier: 'my-extension/add-markup-to-article-pages'

Read :ref:`how to configure dependency injection in extensions <t3coreapi:dependency-injection-in-extensions>`.


.. _event-register-additional-properties:

Register additional properties for a type
=========================================

.. deprecated:: 3.10.0
   This way to extend a type with additional properties has been deprecated
   and will stop working with schema v4.

Sometimes it can be necessary to use properties which are not standardised or
`pending`_, or to add `property annotations`_. Therefore an PSR-14 event is
available which can be used in an event listener.

These additional properties are not only available in the :ref:`API <api>` but
also as arguments in the :ref:`view helpers <view-helpers>`.

The event :php:`\Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent`
provides the following methods:

.. option:: getType(): string

   Returns the class name of the type. You can use this to add a property only
   to one type.

.. option:: getAdditionalProperties(): array

   Retrieve the already defined additionalProperties for this type, for example,
   by other event listeners.

.. option:: registerAdditionalProperty(string $propertyName): void

   This method registers an additional property for one or more types.


Example
~~~~~~~

.. rst-class:: bignums-xxl

#. Create the event listener

   .. literalinclude:: _Events/_AdditionalPropertiesForPerson.php
      :language: php
      :caption: EXT:my_extension/Classes/EventListener/AdditionalPropertiesForPerson.php

   The method :php:`__invoke()` implements the logic for registering additional
   properties for one or more types. It receives the
   :php:`RegisterAdditionalTypePropertiesEvent`. You can register as many
   properties as you want.

#. Register your event listener in :file:`Configuration/Services.yaml`

   .. code-block:: yaml

      services:
         # Place here the default dependency injection configuration

         MyVendor\MyExtension\EventListener\AdditionalPropertiesForPerson:
            tags:
               - name: event.listener
                 identifier: 'my-extension/additional-properties-for-person'

Read :ref:`how to configure dependency injection in extensions <t3coreapi:dependency-injection-in-extensions>`.


.. _pending: https://pending.schema.org/
.. _property annotations: https://schema.org/docs/actions.html#part-4
.. _PSR-14 Events in TYPO3: https://usetypo3.com/psr-14-events.html
