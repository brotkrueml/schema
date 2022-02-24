.. include:: /Includes.rst.txt

.. index:: TypoScript
.. highlight:: typoscript

.. _typoscript:

==========
TypoScript
==========

Target group: **Integrators**

Content Object (cObject) :ts:`SCHEMA`
=====================================

.. versionadded:: 2.3.0

The extension provides the cObject :ts:`SCHEMA`.
The cObject itself will not display anything.
Instead it will add configured types to the global schema output.

A small example::

   page = PAGE
   page.10 = SCHEMA
   page.10 {
       type = WebSite
       properties {
           name.field = seo_title // title
           description.field = description
       }
   }

That will add an element of type ``WebSite`` to schema.
It will consist of the property ``name`` as well as ``description``.
The ``name`` property will be filled from the ``seo_title`` field, falling back to ``title`` field.

.. _typoscript-cobjectSchema-topLevelProperties:

Top Level Properties
--------------------

The cObject :ts:`SCHEMA` provides the following top level properties:

.. container:: table-row

   Property
      type

   Data type
      string /:ref:`stdWrap <t3ts:stdwrap>`

   Description
      Defines the schema type to use, see: :ref:`available-types`.

      **Example:**

      .. code-block:: typoscript

         page.10 = SCHEMA
         page.10.type = WebSite

.. container:: table-row

   Property
      id

   Data type
      string /:ref:`stdWrap <t3ts:stdwrap>`

   Description
      The id added as ``@id`` to the type if defined.

      **Example:**

      .. code-block:: typoscript

         page.10 = SCHEMA
         page.10.type = WebSite
         page.10.id {
             typolink {
                 parameter = t3://page?uid={site : rootPageId}
                 parameter.insertData = 1
                 forceAbsoluteUrl = 1
                 returnLast = url
             }
         }

.. container:: table-row

   Property
      properties

   Data type
      array

   Description
      The key will be used as property name.
      The value is evaluated as TypoScript.

      **Example:**

      .. code-block:: typoscript

         page.10 = SCHEMA
         page.10.type = WebSite
         page.10.properties {
             name.field = seo_title // title
             description.field = description
         }


      A property can be a :ts:`SCHEMA` again, which will result in nested structures.

      **Example:**

      .. code-block:: typoscript

         page.10 = SCHEMA
         page.10.type = WebSite
         page.10.properties {
           publisher = SCHEMA
           publisher {
               id {
                   typolink {
                       parameter = t3://page?uid={site : rootPageId}#organization
                       parameter.insertData = 1
                       forceAbsoluteUrl = 1
                       returnLast = url
                   }
               }
           }
       }

.. container:: table-row

   Property
      if

   Data type
      :ref:`if <t3ts:if>`

   Description
      Prevents processing of the whole cObject if it evaluates to ``false``.

      **Example:**

      .. code-block:: typoscript

         page.10 = SCHEMA
         page.10 {
             if {
                 equals.data = site : rootPageId
                 value.field = uid
             }
             type = WebSite
         }
