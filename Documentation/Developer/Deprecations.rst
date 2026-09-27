.. include:: /Includes.rst.txt

.. _api-deprecations:

============
Deprecations
============

Introduced in version 4
=======================

.. confval:: Prioritisation of mainEntityOfWebPage
   :name: deprecation-prioritisation-addMainEntityOfWebPage

   Deprecated since version
      4.4.0

   Will be removed in version
      5.0.0

   Alternative
      None.

The :ref:`prioritisation <main-entity-prioritisation>` of `mainEntityOfWebPage` via
:confval:`SchemaManager->addMainEntityOfWebPage() <schemamanager-addmainentityofwebpage>`
and the :html:`<schema:type>` view helpers has been introduced to override the
`WebPage` type, for example to force it to a `FAQPage`. This has been claimed by
Google to be able to show rich snippets. As Google `removed the support of FAQs`_
for rich snippets in May 2026, this workaround is not necessary anymore.

.. _removed the support of FAQs: https://developers.google.com/search/updates#removing-faq-rich-result


Introduced in version 3
=======================

.. confval:: Direct instantiation of a type model
   :name: deprecation-directInstantiationOfTypeModel

   Deprecated since version
      3.11.0

   Removed in version
      4.0.0

   Alternative
      Get an instance of a type model via the `TypeFactory`, see
      :ref:`types` for details. A deprecation log entry is written with
      information about the calling class and line number.

.. confval:: PSR-14 event RegisterAdditionalTypePropertiesEvent
   :name: deprecation-RegisterAdditionalTypePropertiesEvent

   Deprecated since version
      3.10.0

   Removed in version
      4.0.0

   Alternative
      Create a class implementing `AdditionalPropertiesInterface`, see
      :ref:`extending-register-additional-properties` for details.

.. confval:: Enumeration type model / view helper classes

   Deprecated since version
      3.9.0

   Removed in version
      4.0.0

   Alternative
      Use the specific enums and the <f:constant> view helper instead, see
      :ref:`enumerations <enumerations>` for details.

.. confval:: \Brotkrueml\Schema\Type\TypeFactory::createType()
   :name: deprecation-TypeFactoryCreateType

   Deprecated since version
      3.0.0

   Removed in version
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
