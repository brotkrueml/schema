.. include:: /Includes.rst.txt

.. _migration:

=========
Migration
=========

From version 1.x to version 2.0
===============================

In version 2.0 the compatibility with TYPO3 v9 LTS was removed.

Signal/Slots
------------

The signal/slots were removed:

- registerAdditionalTypeProperties
- shouldEmbedMarkup

You can migrate the slots easily to the PSR-14 event listeners:

**Previous slot** (in :file:`ext_localconf.php`)::

   $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
   );
   $signalSlotDispatcher->connect(
      \Brotkrueml\Schema\Core\Model\AbstractType::class,
      'registerAdditionalTypeProperties',
      \YourVendor\YourExtension\EventListener\AdditionalPropertiesForPerson::class,
      '__invoke'
   );

**PSR-14 event listener** (in :file:`Configuration/Services.yaml`):

.. code-block:: yaml

   services:
      YourVendor\YourExtension\EventListener\AdditionalPropertiesForPerson:
         tags:
            - name: event.listener
              identifier: 'myAdditionalPropertiesForPerson'
              event: Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent

You can find more information about the PSR-14 event listeners in the chapter
:ref:`events`.
