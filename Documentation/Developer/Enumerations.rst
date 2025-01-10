.. include:: /Includes.rst.txt

.. _enumerations:

============
Enumerations
============

Target group: **Integrators, Developers**

.. versionadded:: 3.9.0
   This feature is considered experimental and may change at any time until it
   is declared stable. However, feedback is welcome.

.. contents:: Table of Contents
   :depth: 1
   :local:


Introduction
============

The schema.org vocabulary provides `enumerations types`_. An enumeration has
one or more members, for example, the `GenderType` use for the `gender` property
has the members `Male` and `Female`.

These enumerations can be used in your code instead of plain strings. This has
the advantage of avoiding typos because you can use your IDE's capabilities.
Also these members are part of a common vocabulary.

You can find the enums provided by the TYPO3 schema extensions in the
:file:`Classes/Model/Enumeration/` folder.

Usage in PHP
============

Usage in PHP is straightforward, in this example we are using the
:php:`\Brotkrueml\Schema\Model\Enumeration\GenderType` enum in the
`gender` property:

.. literalinclude:: _Api/_MyController2.php
   :language: php
   :caption: EXT:my_extension/Classes/Controller/MyController.php
   :emphasize-lines: 7,25

This results in the following output:

.. code-block:: json
   :emphasize-lines: 7

   {
      "@context": "https://schema.org/",
      "@type": "Person",
      "@id": "https://example.org/#person-42",
      "givenName": "John",
      "familyName": "Smith",
      "gender": "https://schema.org/Male",
   }


.. _enumerations-view-helper:

Usage in Fluid templates
========================

The example in the PHP section above can also be adapted for a Fluid template.
We make use of the :ref:`constant view helper <t3viewhelper:typo3fluid-fluid-constant>`
(which is available since Fluid v2.12):

.. code-block:: html
   :emphasize-lines: 5

   <schema:type.person
      -id="https://example.org/#person-42"
      givenName="John"
      familyName="Smith"
      gender="{f:constant(name: '\Brotkrueml\Schema\Model\Enumeration\GenderType::Male')}"
   />

This results in the following output:

.. code-block:: json
   :emphasize-lines: 7

   {
      "@context": "https://schema.org/",
      "@type": "Person",
      "@id": "https://example.org/#person-42",
      "givenName": "John",
      "familyName": "Smith",
      "gender": "https://schema.org/Male",
   }


Create your own enumeration type
================================

Not all enumerations defined by schema.org are provided by this extension (or by
the :ref:`section extensions <vocabulary>`), but only those who have at least
one member defined by schema.org. You may find a schema.org enumeration type
which references members from the `GoodRelations` or from other vocabularies.
If you need them, you can create a custom enum.

Have a look into :ref:`extending-adding-enumeration`.


.. _enumerations types: https://schema.org/Enumeration
