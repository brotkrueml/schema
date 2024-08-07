.. include:: /Includes.rst.txt

.. _typoscript:

==========
TypoScript
==========

Target group: **Integrators**

.. _content-object:

Content Object (cObject) :ts:`SCHEMA`
=====================================

The extension provides the cObject :ts:`SCHEMA`. The cObject itself will not
display anything. Instead it will add configured types to the global schema
output.

A small example:

.. code-block:: typoscript
   :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

   page = PAGE
   page.10 = SCHEMA
   page.10 {
      type = WebSite
      properties {
         name.field = seo_title // title
         description.field = description
      }
   }

That will add an element of type `WebSite` to schema. It will consist of the
property `name` as well as `description`.
The `name` property will be filled from the `seo_title` field, falling back to
the `title` field.

.. note::
   Using the :ts:`SCHEMA` cObject in an array-like structure is **not** possible
   by now, like the following example:

   .. code-block:: json

      {
         "@context": "https://schema.org/",
         "@type": "Event",
         "offers": [{
            "@type": "Offer",
            "name": "Ticket 1",
            "price": "80",
            "priceCurrency": "EUR"
         }, {
            "@type": "Offer",
            "name": "Ticket 2",
            "price": "120",
            "priceCurrency": "EUR"
         }]
      }

   For example, a :ref:`USER <t3tsref:cobj-user>` cObject and the
   :ref:`PHP API <api>` can be used instead.

.. _typoscript-cobjectSchema-topLevelProperties:

Top-level properties
--------------------

The cObject :ts:`SCHEMA` provides the following top-level properties:

.. confval:: type
   :name: cobject-schema-type
   :Data type: string / :ref:`stdWrap <t3tsref:stdwrap>`

   Defines the schema type to use, see: :ref:`available-types`.

   **Example:**

   .. code-block:: typoscript
      :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

      page.10 = SCHEMA
      page.10.type = WebSite

.. confval:: id
   :name: cobject-schema-id
   :Data type: string / :ref:`stdWrap <t3tsref:stdwrap>`

   The ID added as `@id` to the type, if defined.

   **Example:**

   .. code-block:: typoscript
      :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

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

.. confval:: properties
   :name: cobject-schema-properties
   :Data type: array

   The key will be used as property name.
   The value can be a static text, an array, a content object, a
   :ref:`stdWrap <t3tsref:stdwrap>` property or an :ref:`if <t3tsref:if>` condition.

   **Example:**

   .. code-block:: typoscript
      :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

      page.10 = SCHEMA
      page.10.type = WebSite
      page.10.properties {
         name.field = seo_title // title
         description.field = description
      }

   A property can be a :ts:`SCHEMA` again, which will result in nested structures.

   **Example:**

   .. code-block:: typoscript
      :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript
      :emphasize-lines: 4-14

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

   Multiple values can also be assigned to one property using numeric keys.

   **Example:**

   .. code-block:: typoscript
      :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript
      :emphasize-lines: 6-13

      page.10 = SCHEMA
      page.10 {
         type = Organization
         properties {
            name = My Company
            sameAs {
               10 = https://example.org/
               20.typolink {
                  parameter = t3://page?uid=42
                  forceAbsoluteUrl = 1
                  returnLast = url
               }
            }
         }
      }

.. confval:: if
   :name: cobject-schema-if
   :Data type: :ref:`if <t3tsref:if>`

   Prevents processing of the whole cObject if it evaluates to `false`.

   **Example:**

   .. code-block:: typoscript
      :caption: EXT:my_extension/Configuration/TypoScript/setup.typoscript

      page.10 = SCHEMA
      page.10 {
         if {
            equals.data = site : rootPageId
            value.field = uid
         }
         type = WebSite
      }
