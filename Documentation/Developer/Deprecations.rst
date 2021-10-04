.. include:: /Includes.rst.txt

.. index:: Deprecations

.. _api-deprecations:

============
Deprecations
============

.. option:: Brotkrueml\\Schema\\Core\\Model\\AbstractType->isEmpty()

Deprecated since version
   1.7.0

Removed in version
   2.0.0

Alternative
   None. If you need it use
   :php:`Brotkrueml\Schema\Core\Model\AbstractType->getPropertyNames()`
   and loop over the property names with
   :php:`Brotkrueml\Schema\Core\Model\AbstractType->getProperty()`.


.. option:: Brotkrueml\\Schema\\Manager\\SchemaManager->setMainEntityOfWebPage()

Deprecated since version
   1.4.1

Removed in version
   2.0.0

Alternative
   Use :php:`Brotkrueml\Schema\Manager\SchemaManager->addMainEntityOfWebPage()`
   instead. See the :ref:`API <api-schema-manager-addmainentityofwebpage>`.

.. note::
   Use the `brotkrueml/schema-rector`_ package for migrating the code with
   `Rector`_ automatically.

.. option:: Brotkrueml\\Schema\\Provider\\TypesProvider

Deprecated since version
   1.7.0

Removed in version
   2.0.0

Alternative
   Use :php:`Brotkrueml\Schema\Type\TypeRegistry` which is a singleton
   and can be instantiated with :php:`GeneralUtility::makeInstance()` or
   injected with dependency injection. See section :ref:`api-list-of-types`.


.. _brotkrueml/schema-rector: https://github.com/brotkrueml/schema-rector
.. _Rector: https://getrector.org/
