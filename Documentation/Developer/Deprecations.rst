.. include:: /Includes.rst.txt

.. _api-deprecations:

============
Deprecations
============

Introduced in version 3
=======================

.. confval:: \Brotkrueml\Schema\Type\TypeFactory::createType()

   Deprecated since version
      3.0.0

   Will be removed in version
      4.0.0

   Alternative
      Inject the :php:`TypeFactory` into the constructor and use the
      :php:`create()` method.
      Have a look at the :ref:`migration <migration-type-factory>` section.


Introduced in version 1
=======================

.. confval:: \Brotkrueml\Schema\Core\Model\AbstractType->isEmpty()

   Deprecated since version
      1.7.0

   Removed in version
      2.0.0

   Alternative
      None. If you need it use
      :php:`\Brotkrueml\Schema\Core\Model\AbstractType->getPropertyNames()`
      and loop over the property names with
      :php:`\Brotkrueml\Schema\Core\Model\AbstractType->getProperty()`.


.. confval:: \Brotkrueml\Schema\Manager\SchemaManager->setMainEntityOfWebPage()

   Deprecated since version
      1.4.1

   Removed in version
      2.0.0

   Alternative
      Use :php:`\Brotkrueml\Schema\Manager\SchemaManager->addMainEntityOfWebPage()`
      instead. See the :ref:`API <api-schema-manager-addmainentityofwebpage>`.

.. confval:: \Brotkrueml\Schema\Provider\TypesProvider

   Deprecated since version
      1.7.0

   Removed in version
      2.0.0

   Alternative
      Use :php:`\Brotkrueml\Schema\Type\TypeRegistry` which is a singleton
      and can be instantiated with :php:`GeneralUtility::makeInstance()` or
      injected with dependency injection.

      Since version 3.0 there is no alternative available.
