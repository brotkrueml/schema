.. include:: ../Includes.txt

.. index:: Signal
.. index:: PSR-14 Events

.. _events:

=========================
PSR-14 Events and Signals
=========================

Target group: **Developers**

Activate or Deactivate Embedding of Markup on Pages
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

:aspect:`->getPage(): array`

   Get the current page fields.

:aspect:`->getEmbedMarkup(): bool`

   Gets the current status: :php:`true` if the markup should be embedded,
   :php:`false` if not.

:aspect:`->setEmbedMarkup(bool $embedMarkup): void`

   Sets the status: :php:`true` if the markups should be embedded, :php:`false`
   if not.

.. attention::

   In TYPO3 v10 you can use signal/slots **and** PSR-14 events. If you use both,
   the PSR-14 events are called first, and the signal/slots operate on the
   modified event from the PSR-14 events.


PSR-14 Event (for TYPO3 v10+)
-----------------------------

With the PSR-14 event :php:`Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent` you
can activate or deactivate the embedding of markup on a specific page.

.. note::

   This is the preferred way for TYPO3 v10+.

Example
~~~~~~~

.. rst-class:: bignums-xxl

#. Create the Event Listener

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
                 identifier: 'ext-schema/shouldEmbedMarkup'
                 event: Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent

.. seealso::

   You can find more information about PSR-14 events in the blog article
   `PSR-14 Events in TYPO3 <https://usetypo3.com/psr-14-events.html>`_
   and the official
   `TYPO3 documentation <https://docs.typo3.org/m/typo3/reference-coreapi/master/en-us/ApiOverview/Hooks/EventDispatcher/Index.html>`_.


Signal/Slot (for TYPO3 v9/v10)
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
         public function changeEmbedMarkup(ShouldEmbedMarkupEvent $event): void
         {
            $page = $event->getPage();

            if ($page['uid'] === 42) {
               $event->setEmbedMarkup(true);
            }
         }
      }

   In this example, the method :php:`changeEmbedMarkup()` implements the logic
   for the embedding of the markup. It receives the
   :php:`ShouldEmbedMarkupEvent`. Assign a new state with the
   :php:`setEmbedMarkup()` method.

#. Register the Slot in :file:`ext_localconf.php`

   ::

      $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
         TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
      );
      $signalSlotDispatcher->connect(
         \Brotkrueml\Schema\Hooks\PageRenderer\SchemaMarkupInjection::class,
         'shouldEmbedMarkup',
         \YourVendor\YourExtension\Slot\EmbedMarkupDependentOnPageUid::class,
         'changeEmbedMarkup'
      );

   The third argument of the :php:`connect()` method is your slot class and the
   forth argument the method name of that class.

.. seealso::

   You can find more information about signal/slots in the blog article
   `Signals and Slots – Extend TYPO3 Functionality <https://typo3worx.eu/2017/07/signals-and-slots-in-typo3/>`_.
