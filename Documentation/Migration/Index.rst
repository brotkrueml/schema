.. include:: /Includes.rst.txt

.. _migration:

=========
Migration
=========

.. contents:: Table of Contents
   :depth: 2
   :local:

From version 2.x to version 3.0
===============================

In version 3.0 the compatibility with TYPO3 v10 LTS was removed. Also PHP 8.1
or higher is necessary.

Type model classes
------------------

The type models classes were previously registered via a
:file:`Configuration/TxSchema/TypeModels.php` file. This file is not recognised
anymore, you have to mark a type model class with the attribute
:php:`\Brotkrueml\Schema\Attributes\Type` now. See the
:ref:`extending-adding-types` section for more information.

Additionally, the static property :php:`$propertyNames` of a type model class is
now type-hinted as an array:

.. code-block:: diff

     final class MyCustomType extends AbstractType
     {
   -     protected static $propertyNames = [
   +     protected static array $propertyNames = [
            // ... the properties ...
         ]
     }

From version 1.x to version 2.0
===============================

In version 2.0 the compatibility with TYPO3 v9 LTS was removed. Also PHP 7.4
or higher is necessary.


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


Removed Deprecations
--------------------

The following :ref:`deprecated methods and classes <api-deprecations>` were
removed:

- :php:`Brotkrueml\Schema\Core\Model\AbstractType->isEmpty()`
- :php:`Brotkrueml\Schema\Manager\SchemaManager->setMainEntityOfWebPage()`
- :php:`Brotkrueml\Schema\Provider\TypesProvider`

For the migration of the :php:`SchemaManager->setMainEntityOfWebPage()` method
call a `Rector`_ exists. For the other two follow the instructions on the
:ref:`deprecations <api-deprecations>` chapter.


Markup is embedded by default on "noindex" pages
------------------------------------------------

In schema version 1.x the markup was not embedded on "noindex" pages (with
installed :ref:`SEO system extension <ext_seo:introduction>`). In version 2
the markup is embedded by default also on these pages. You can deactivate this
behaviour in the :ref:`extension configuration
<configuration-embedMarkupOnNoindexPages>`.

Also in version 1.x a PSR-14 event
:php:`Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent` was available to change
the default behaviour of not embedding the markup on "noindex" pages. With the
new configuration option this is not necessary anymore and event listeners for
this event must be removed.


.. _Rector: https://github.com/brotkrueml/schema-rector
