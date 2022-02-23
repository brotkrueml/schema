.. include:: /Includes.rst.txt

.. index:: TypoScript
.. highlight:: typoscript

.. _typoscript:

==========
TypoScript
==========

Target group: **Integrators**

.. contents:: Table of Contents
   :depth: 1
   :local:

cObject :ts:`SCHEMA`
====================

.. versionadded:: 2.3.0

The extension provides a cObject :ts:`SCHEMA`.
The cObject itself will not output anything.
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

That will add an entry of type ``WebSite`` to schema.
It will consist of the property ``name`` as well as ``description``.
The ``name`` property will be filled from the ``seo_title`` field, falling back to ``title`` field.

.. _typoscript-cobjectSchema-topLevelProperties:

Top Level Properties
--------------------

The cObject :ts:`SCHEMA` provides the following top level properties:

:ts:`type`
   Mandatory.
   Defines the schema type to use, see: :ref:`available-types`.
   Example::

      page.10 = SCHEMA
      page.10.type = WebSite

:ts:`id`
   The id added as ``@id`` to the type if defined.
   Example::

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

:ts:`properties`
   The key will be used as property name.
   The value is evaluated as TypoScript.
   Example::

      page.10 = SCHEMA
      page.10.type = WebSite
      page.10.properties {
          name.field = seo_title // title
          description.field = description
      }


   A property can be a :ts:`SCHEMA` again, which will result in nested structures.
   Example::

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

:ts:`if`
   Evaluated as TypoScript :ts:`if`.
   Prevents processing of the whole cObject if it evaluates to ``false``.
   See: :ref:`TypoScript Reference <t3ts:if>`.
   Example::

      page.10 = SCHEMA
      page.10 {
          if {
              equals.data = site : rootPageId
              value.field = uid
          }
          type = WebSite
      }

