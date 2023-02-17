.. include:: /Includes.rst.txt

.. index:: PSR-14 Events

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


.. _event-register-additional-properties:

Register additional properties for a type
=========================================

.. versionadded:: 1.6.0

Sometimes it can be necessary to use properties which are not standardised or
`pending`_, or to add `property annotations`_. Therefore an PSR-14 event is
available which can be used in an event listener.

These additional properties are not only available in the :ref:`API <api>` but
also as arguments in the :ref:`view helpers <view-helpers>`.

The event :php:`Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent`
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

   ::

      <?php
      declare(strict_types=1);

      namespace YourVender\YourExtension\EventListener;

      use Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent;
      use Brotkrueml\Schema\Model\Type\Person;

      final class AdditionalPropertiesForPerson
      {
         public function __invoke(RegisterAdditionalTypePropertiesEvent $event): void
         {
            if ($event->getType() === Person::class) {
               $event->registerAdditionalProperty('gender');
               $event->registerAdditionalProperty('jobTitle');
            }
         }
      }

   The method :php:`__invoke()` implements the logic for registering additional
   properties for one or more types. It receives the
   :php:`RegisterAdditionalTypePropertiesEvent`. You can register as many
   properties as you want.

#. Register your event listener in :file:`Configuration/Services.yaml`

   .. code-block:: yaml

      services:
         YourVendor\YourExtension\EventListener\AdditionalPropertiesForPerson:
            tags:
               - name: event.listener
                 identifier: 'myAdditionalPropertiesForPerson'


.. _pending: https://pending.schema.org/
.. _property annotations: https://schema.org/docs/actions.html#part-4
.. _PSR-14 Events in TYPO3: https://usetypo3.com/psr-14-events.html
