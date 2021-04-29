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
   `PSR-14 Events in TYPO3 <https://usetypo3.com/psr-14-events.html>`_
   and the official `TYPO3 documentation
   <https://docs.typo3.org/m/typo3/reference-coreapi/master/en-us/ApiOverview/Hooks/EventDispatcher/Index.html>`_.


.. _event-register-additional-properties:

Register additional properties for a type
=========================================

Sometimes it can be necessary to use properties which are not standardised or
`pending <https://pending.schema.org/>`_, or to add `property annotations
<https://schema.org/docs/actions.html#part-4>`_. Therefore an PSR-14 event is
available which can be used in an event listener.

These additional properties are not only available in the :ref:`API <api>` but
also as arguments in the :ref:`view helpers <view-helpers>`.

The event :php:`Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent`
provides the following methods:

.. option:: getType(): string

Returns the class name of the type. You can use this to add a property only
to one type.

.. option:: getAdditionalProperties(): array

Retrieve the already defined additionalProperties for this type, e.g. by other
event listeners.

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
                 event: Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent


.. _event-de-activate-embedding-of-markup:

Activate or deactivate embedding of markup on pages
===================================================

As default, markup is not embedded on pages which should not be indexed by
search engines (if the seo system extension is used). But sometimes it's
intentional to add markup on such a page, e.g. you declared a detail page as
``noindex`` in the page properties, but the plugin on that page changes it to
``index``.

The PSR-14 event listener receives a
:php:`Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent` with the following
methods:

.. option:: getPage(): array

Get the current page fields.

.. option:: getEmbedMarkup(): bool

Gets the current status: :php:`true` if the markup should be embedded,
:php:`false` if not.

.. option:: setEmbedMarkup(bool $embedMarkup): void

Sets the status: :php:`true` if the markups should be embedded, :php:`false`
if not.


PSR-14 event
------------

With the PSR-14 event :php:`Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent` you
can activate or deactivate the embedding of markup on a specific page.

.. note::

   It can be necessary to :ref:`define an order <t3coreapi:EventDispatcherRegistration>`
   for these event listeners. Use :yaml:`before` or :yaml:`after` for this
   when configuring the event listener in the :file:`Configuration/Services.yaml`
   file. Also note that this extension ships an event listener for deactivating
   the embedding of structured data dependent on the ``noindex`` field of the
   seo system extension.

Example
~~~~~~~

.. rst-class:: bignums-xxl

#. Create the event listener

   ::

      <?php
      declare(strict_types=1);

      namespace YourVender\YourExtension\EventListener;

      use Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent;

      final class EmbedMarkupDependentOnPageUid
      {
         public function __invoke(ShouldEmbedMarkupEvent $event): void
         {
            $page = $event->getPage();

            if ($page['uid'] === 42) {
               $event->setEmbedMarkup(true);
            }
         }
      }

   The method :php:`__invoke()` implements the logic for changing the embedding
   of the markup. It receives the :php:`ShouldEmbedMarkupEvent`. Assign a new
   state with the :php:`setEmbedMarkup()` method.

#. Register your event listener in :file:`Configuration/Services.yaml`

   .. code-block:: yaml

      services:
         YourVendor\YourExtension\EventListener\EmbedMarkupDependentOnPageUid:
            tags:
               - name: event.listener
                 identifier: 'myLogicForEmbeddingMarkup'
                 event: Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent
