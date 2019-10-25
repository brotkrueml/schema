.. include:: ../Includes.txt

.. index:: Configuration

.. _configuration:

=============
Configuration
=============

Target group: **Developers, Integrators**

To configure the extension, go to *Admin Tools* > *Settings* > *Extension Configuration* and click on the
*Configure extensions* button. Open the *schema* configuration:

.. figure:: ../Images/Configuration/ExtensionConfiguration.png
   :alt: Options in the extension configuration

   Options in the extension configuration

.. index:: WebPage automatic embedding

.. _configuration-automaticWebPageSchemaGeneration:

basic.automaticWebPageSchemaGeneration
--------------------------------------

If this option is enabled, the ``WebPage`` type schema is automatically embedded into the page.
The web page type can be defined in the field *Specific type of web page* of the :ref:`page properties <for-editors>`
and defaults to :ref:`WebPage <web-page-type>`.

:aspect:`Default value`

   enabled

.. index::
   single: Breadcrumb automatic embedding

.. _configuration-automaticBreadcrumbSchemaGeneration:

basic.automaticBreadcrumbSchemaGeneration
-----------------------------------------

If this option is enabled, the breadcrumb is automatically generated from the rootline of the current page.

:aspect:`Default value`

   disabled

.. NOTE::

   Since multiple breadcrumbs are allowed for a page, this option adds a breadcrumb to the possibly already existing ones
   (e.g. defined via the :ref:`API <breadcrumb-api>` or the :ref:`view helpers <breadcrumb-viewhelpers>`).


.. index:: Markup in body section

.. _configuration-embedMarkupInBodySection:

basic.embedMarkupInBodySection
------------------------------

If this option is enabled, the schema markup is embedded at the end of the :html:`<body>` section. If it is disabled,
it is embedded in the :html:`<head>` section of the page.

:aspect:`Default value`

   disabled

.. youtube:: lI6EtxjoyDU
