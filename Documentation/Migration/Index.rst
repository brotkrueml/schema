.. include:: /Includes.rst.txt

.. _migration:

=========
Migration
=========

.. contents:: Table of Contents
   :depth: 2
   :local:

From version 3.x to version 4.0
===============================

In version 4.0, the compatibility with TYPO3 v11 LTS and TYPO3 v12 LTS has been
removed.

PSR-14 event `RegisterAdditionalTypePropertiesEvent`
----------------------------------------------------

The :confval:`deprecated <deprecation-RegisterAdditionalTypePropertiesEvent>`
PSR-14 event `RegisterAdditionalTypePropertiesEvent` has been removed. As an
alternative create a class implementing `AdditionalPropertiesInterface`
(which is available since version 3.10.0), see
:ref:`extending-register-additional-properties` for details.

Manual instantiation of a type model class
------------------------------------------

Instantiating a type model class manually with "new" is not supported anymore.
The :php:`\Brotkrueml\Schema\Type\TypeFactory->create()` method should be used
instead (which is available since version 3.0.0):

.. code-block:: diff

     use Brotkrueml\Schema\Model\Type\Event;
   + use Brotkrueml\Schema\Type\TypeFactory;

     final class MyController
     {
   +     public function __construct(
   +         private readonly TypeFactory $typeFactory,
   +     ) {}

         public function doSomething(): void
         {
             // ...

   -         $event = new Event();
   +         $event = $this->typeFactory->create('Event');

             // ...
         }
     }

.. seealso::

   *  :ref:`Create a model via the TypeFactory <types>`
   *  :confval:`Deprecation: direct instantiation of a type model <deprecation-directInstantiationOfTypeModel>`
   *  :confval:`Deprecation: TypeFactory::createType() method <deprecation-TypeFactoryCreateType>`

Types and view helpers representing enumerations
------------------------------------------------

Types and view helpers representing enumerations were removed. It is unlikely
that they were used as they had no real purpose. Use real
:ref:`enumerations <enumerations>` instead which are available since version
3.9.0.

Properties moved from core to pending
-------------------------------------

Over the time some properties moved from the core vocabulary to pending with
newer version of the Schema.org definition (for whatever reason). To avoid
breaking, these properties were reapplied to the corresponding type models.
Those properties have now been removed. If you need some of them, register them
yourself like explained in :ref:`extending-register-additional-properties` or
install the `schema_pending`_ extension.

.. _schema_pending: https://extensions.typo3.org/extension/schema_pending

Type declarations added to :php:`TypeInterface`
-----------------------------------------------

Missing return type declarations and type declarations for the argument of the
`setId()` method have been added. If you do not implement custom type models
directly from the :php:`\Brotkrueml\Schema\Core\Model\TypeInterface`, you are
not affected by this change. Otherwise you have to adjust the methods of your
type model classes.

However, implementing a type model directly from the interface is
discouraged and might not work in the future, extend from
:php:`\Brotkrueml\Schema\Core\Model\AbstractType` instead.

.. seealso::
   *  :ref:`extending-adding-types`


From version 2.x to version 3.0
===============================

In version 3.0, the compatibility with TYPO3 v10 LTS was removed. Also PHP 8.1
or higher is necessary.

Type model classes
------------------

The type models classes were previously registered via a
:file:`Configuration/TxSchema/TypeModels.php` file. This file is not recognised
anymore, you have to mark a type model class with the attribute
:php:`\Brotkrueml\Schema\Attributes\Type` now. See the
:ref:`extending-adding-types` section for more information.

Additionally, the static property :php:`$propertyNames` of a type model class is
now type-hinted as an array.

.. code-block:: diff

   + use Brotkrueml\Schema\Attributes\Type;

   + #[Type('MyCustomType')]
     final class MyCustomType extends AbstractType
     {
   -     protected static $propertyNames = [
   +     protected static array $propertyNames = [
            // ... the properties ...
         ]
     }

View helpers
------------

Custom view helpers need to specify a property which holds the name of the
type:

.. code-block:: diff

     final class MyCustomTypeViewHelper extends AbstractTypeViewHelper
     {
   +     protected string $type = 'MyCustomType';
     }

.. _migration-type-factory:

Type factory
------------

The call of the static method :php:`\Brotkrueml\Schema\Type\TypeFactory::createType()`
has been deprecated. Instead, inject the :php:`TypeFactory` into the constructor
and use the new :php:`create()` method:

.. code-block:: diff

    <?php

    declare(strict_types=1);

    namespace MyVendor\MyExtension\Controller;

    use Brotkrueml\Schema\Type\TypeFactory;

    final class MyController
    {
   +    public function __construct(
   +        private readonly TypeFactory $typeFactory,
   +    ) {}

        public function doSomething(): void
        {
            // ...

   -        $person = TypeFactory::createType('Person');
   +        $person = $this->typeFactory->create('Person');

            // ...
        }
    }



From version 1.x to version 2.0
===============================

In version 2.0, the compatibility with TYPO3 v9 LTS was removed. Also PHP 7.4
or higher is necessary.


Signal/Slots
------------

The signal/slots were removed:

*  registerAdditionalTypeProperties
*  shouldEmbedMarkup

You can migrate the slots easily to the PSR-14 event listeners:

**Previous slot** (in :file:`ext_localconf.php`):

.. code-block:: php
   :caption: EXT:my_extension/ext_localconf.php

   $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class
   );
   $signalSlotDispatcher->connect(
      \Brotkrueml\Schema\Core\Model\AbstractType::class,
      'registerAdditionalTypeProperties',
      \MyVendor\MyExtension\EventListener\AdditionalPropertiesForPerson::class,
      '__invoke'
   );

**PSR-14 event listener** (in :file:`Configuration/Services.yaml`):

.. code-block:: yaml

   services:
      # Place here the default dependency injection configuration

      MyVendor\MyExtension\EventListener\AdditionalPropertiesForPerson:
         tags:
            - name: event.listener
              identifier: 'myAdditionalPropertiesForPerson'

You can find more information about the PSR-14 event listeners in the chapter
:ref:`events`.


Removed Deprecations
--------------------

The following :ref:`deprecated methods and classes <api-deprecations>` were
removed:

*  :php:`\Brotkrueml\Schema\Core\Model\AbstractType->isEmpty()`
*  :php:`\Brotkrueml\Schema\Manager\SchemaManager->setMainEntityOfWebPage()`
*  :php:`\Brotkrueml\Schema\Provider\TypesProvider`

For the migration follow the instructions on the
:ref:`deprecations <api-deprecations>` chapter.


Markup is embedded by default on "noindex" pages
------------------------------------------------

In schema version 1.x the markup was not embedded on "noindex" pages (with
installed :ref:`SEO system extension <typo3/cms-seo:introduction>`). In version 2
the markup is embedded by default also on these pages. You can deactivate this
behaviour in the :ref:`extension configuration
<configuration-embedMarkupOnNoindexPages>`.

Also in version 1.x a PSR-14 event
:php:`\Brotkrueml\Schema\Event\ShouldEmbedMarkupEvent` was available to change
the default behaviour of not embedding the markup on "noindex" pages. With the
new configuration option this is not necessary anymore and event listeners for
this event must be removed.
