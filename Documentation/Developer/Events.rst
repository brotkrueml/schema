.. include:: ../Includes.txt

.. index:: Signals
.. index:: PSR-14 Events

.. _events:

=========================
PSR-14 events and signals
=========================

Target group: **Developers**

.. contents:: Table of Contents
   :depth: 2
   :local:

Introduction
============

There are currently two ways to enhance the functionality in the schema
extension. Both variants receive an event that provides methods for retrieving
and setting dedicated properties. The class for a slot can be easily reused for
later use as a PSR-14 event listener during migration.

.. attention::

   In TYPO3 v10 you can use signal/slots **and** PSR-14 events. If you use both,
   the PSR-14 events are called first in this extension, and the signal/slots
   operate on the modified event from the PSR-14 events.


PSR-14 events
-------------

The standardised way, which is available since TYPO3 v10. If you are using TYPO3
v10, use event listeners to be future-proof.

.. seealso::

   You can find more information about PSR-14 events in the blog article
   `PSR-14 Events in TYPO3 <https://usetypo3.com/psr-14-events.html>`_
   and the official
   `TYPO3 documentation <https://docs.typo3.org/m/typo3/reference-coreapi/master/en-us/ApiOverview/Hooks/EventDispatcher/Index.html>`_.


Signal/slots
------------

This is the only way in TYPO3 v9 and deprecated in TYPO3 v10.

.. seealso::

   You can find more information about signal/slots in the blog article
   `Signals and Slots – Extend TYPO3 Functionality <https://typo3worx.eu/2017/07/signals-and-slots-in-typo3/>`_.


.. _event-register-additional-properties:

Register additional properties for a type
=========================================

Sometimes it can be necessary to use properties which are not standardised or
`pending <https://pending.schema.org/>`_, or to add `property annotations
<https://schema.org/docs/actions.html#part-4>`_. Therefore an event is available
which can be used in a slot (TYPO3 v9/v10) and a PSR-14 event listener
(TYPO3 v10+).

These additional properties are not only available in the :ref:`API <api>` but
also as arguments in the :ref:`view helpers <view-helpers>`.

The event :php:`Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent`
provides the following methods:

.. option:: getType(): string

Returns the class name of the type. You can use this to add a property only
to one type.

.. option:: getAdditionalProperties(): array

Retrieve the already defined additionalProperties for this type, e.g. by other
slots/event listeners.

.. option:: registerAdditionalProperty(string $propertyName): void

This method registers an additional property for one or more types.


PSR-14 event (for TYPO3 v10+)
-----------------------------

.. note::

   This is the preferred way for TYPO3 v10+.

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

Signal/slot (for TYPO3 v9/v10)
------------------------------

.. note::

   If you use TYPO3 v10 you should use the PSR-14 event above. The signal/slot
   will be deleted when the compatibility of this extension for TYPO3 v9 is
   removed in later versions.

Example
~~~~~~~

We use the same example as for the PSR-14 event.

.. rst-class:: bignums-xxl

#. Create the slot

   ::

      <?php
      declare(strict_types=1);

      namespace YourVendor\YourExtension\Slot;

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

   In this example, the method :php:`__invoke()` implements the logic
   for registering the additional properties. It receives the
   :php:`RegisterAdditionalTypePropertiesEvent`. Assign a new state with the
   :php:`registerAdditionalProperty()` method. If you compare this slot with
   the event listener above, the only change is the namespace. This makes
   migration to the PSR-14 events much easier.

#. Register the slot in :file:`ext_localconf.php`

   ::

      $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
         TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
      );
      $signalSlotDispatcher->connect(
         \Brotkrueml\Schema\Core\Model\AbstractType::class,
         'registerAdditionalTypeProperties',
         \Brotkrueml\Schema\EventListener\AdditionalPropertiesForPerson::class,
         '__invoke'
      );

   The third argument of the :php:`connect()` method is your slot class and the
   forth argument the method name of that class.


.. _event-de-activate-embedding-of-markup:

Activate or deactivate embedding of markup on pages
===================================================

As default, markup is not embedded on pages which should not be indexed by
search engines (if the seo system extension is used). But sometimes it's
intentional to add markup on such a page, e.g. you declared a detail page as
``noindex`` in the page properties, but the plugin on that page changes it to
``index``.

For TYPO3 v9/v10 you can use a signal/slot, for TYPO3 v10+ is also a PSR-14
event available to change the default behaviour.

Both versions receive the
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


PSR-14 event (for TYPO3 v10+)
-----------------------------

With the PSR-14 event :php:`Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent` you
can activate or deactivate the embedding of markup on a specific page.

.. note::

   This is the preferred way for TYPO3 v10+.

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


Signal/slot (for TYPO3 v9/v10)
------------------------------

The signal :php:`shouldEmbedMarkup` of the
:php:`Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection`
class enables you to modify the embedding of the markup on a page.

.. note::

   If you use TYPO3 v10 you should use the PSR-14 event above. The signal/slot
   will be deleted when the compatibility of this extension for TYPO3 v9 is
   removed in later versions.

Example
~~~~~~~

We use the same example as for the PSR-14 event.

.. rst-class:: bignums-xxl

#. Create the Slot

   ::

      <?php
      declare(strict_types=1);

      namespace YourVendor\YourExtension\Slot;

      use Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent;

      class EmbedMarkupDependentOnPageUid
      {
         public function __invoke(ShouldEmbedMarkupEvent $event): void
         {
            $page = $event->getPage();

            if ($page['uid'] === 42) {
               $event->setEmbedMarkup(true);
            }
         }
      }

   In this example, the method :php:`__invoke()` implements the logic
   for the embedding of the markup. It receives the
   :php:`ShouldEmbedMarkupEvent`. Assign a new state with the
   :php:`setEmbedMarkup()` method. If you compare this slot with the event
   listener above, the only change is the namespace. This makes migration to
   the PSR-14 events much easier.

#. Register the Slot in :file:`ext_localconf.php`

   ::

      $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
         TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
      );
      $signalSlotDispatcher->connect(
         \Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection::class,
         'shouldEmbedMarkup',
         \YourVendor\YourExtension\Slot\EmbedMarkupDependentOnPageUid::class,
         '__invoke'
      );

   The third argument of the :php:`connect()` method is your slot class and the
   forth argument the method name of that class.
