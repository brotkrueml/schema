.. include:: ../Includes.txt


.. _extend-schema:

=============
Extend Schema
=============

Target group: **Developers**


Signals
=======

The behaviour of EXT:schema can be modified with signals - currently one signal is available.


Add additional properties to one type
-------------------------------------

Sometimes it is necessary to use a pending property in a specific type. For example, the property
`jobTitle <https://schema.org/jobTitle>`__ is a pending property in a ``Person`` type, which can be pretty useful.

Example
~~~~~~~

To fulfill the signal, you have to create a slot in your custom extension. Add the configuration in your :file:`ext_localconf.php` file:

.. code-block:: php

   /** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
   $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
      TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher::class
   );

   $signalSlotDispatcher->connect(
      \Brotkrueml\Schema\Core\Model\AbstractType::class,
      'registerAdditionalPropertiesForTypes',
      \YourVendor\YourExtensionKey\Slot\AbstractTypeSlot::class, // your choice
      'addAdditionalProperties' // your choice
   );

An implementation could look like this:

.. code-block:: php

   <?php
   namespace YourVendor\YourExtensionKey\Slot;

   use Brotkrueml\Schema\Signal\PropertyRegistration;

   class AbstractTypeSlot
   {
      public function addAdditionalProperties(PropertyRegistration $propertyRegistration): void
      {
         $propertyRegistration->addPropertyForType(
            'Person', // The schema.org type you want to extend
            'jobTitle' // The additional property
         );

         // ... You can add more properties for the same or different types
      }
   }

Now you can use the additional property with the API:

.. code-block:: php

   $person = new \Brotkrueml\Schema\Model\Type\Person();
   $person->addProperty('jobTitle', 'Software Developer');

and also in the according view helper:

.. code-block:: html

   <schema:type.person jobTitle="Software Developer"/>

.. NOTE::

   The property is not inherited to its schema.org descendants. So you have to add a property, e.g. not only to ``Place``, but
   also to ``Bridge``, ``Museum``, ``Park``, etc.
