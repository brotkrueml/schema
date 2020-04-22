.. include:: ../Includes.txt

.. index:: Deprecations

.. _api-deprecations:

============
Deprecations
============

.. option:: Brotkrueml\Schema\Core\Model\AbstractType->isEmpty()

Deprecated since version
   1.7.0

Will be removed in version
   2.0.0

Alternative
   None. If you need it use
   :php:`Brotkrueml\Schema\Core\Model\AbstractType->getPropertyNames()`
   and loop over the property names with
   :php:`Brotkrueml\Schema\Core\Model\AbstractType->getProperty()`.


.. option:: Brotkrueml\Schema\Manager\SchemaManager->setMainEntityOfWebPage()

Deprecated since version
   1.4.1

Will be removed in version
   2.0.0

Alternative
   Use :php:`Brotkrueml\Schema\Manager\SchemaManager->addMainEntityOfWebPage()`
   instead. See the :ref:`API <api-schema-manager-addmainentityofwebpage>`.


.. option:: Brotkrueml\Schema\Provider\TypesProvider

Deprecated since version
   1.7.0

Will be removed in version
   2.0.0

Alternative
   Use :php:`Brotkrueml\Schema\Type\TypeRegistry` which is a singleton
   and can be instantiated with :php:`GeneralUtility::makeInstance()` or
   injected with dependency injection in TYPO3 v10+. See section
   :ref:`api-list-of-types`.
