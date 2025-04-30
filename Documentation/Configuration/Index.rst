.. include:: /Includes.rst.txt

.. _configuration:

=============
Configuration
=============

Target group: **Developers, Integrators**

.. contents:: Table of Contents
   :depth: 1
   :local:


Extension configuration
=======================

To configure the extension, go to
:guilabel:`Admin Tools > Settings > Extension Configuration` and click on the
:guilabel:`Configure extensions` button. Open the :guilabel:`schema`
configuration:

.. figure:: /Images/Configuration/ExtensionConfiguration.png
   :alt: Options in the extension configuration

   Options in the extension configuration

.. _configuration-automaticWebPageSchemaGeneration:

Automatic embedding of the WebPage schema into the page
-------------------------------------------------------

If this option is enabled, the `WebPage` type schema is automatically embedded
into the page. The web page type can be defined in the field
:guilabel:`Specific type of web page` of the :ref:`page properties <for-editors>`
and defaults to :ref:`WebPage <web-page-type>`.

Default value
   enabled

.. _configuration-automaticBreadcrumbSchemaGeneration:

Automatic embedding of the breadcrumb markup into the page
----------------------------------------------------------

If this option is enabled, the breadcrumb is automatically generated from the
rootline of the current page.

Default value
   disabled

.. note::
   Since multiple breadcrumbs are allowed for a page, this option adds a
   breadcrumb to the possibly already existing ones (for example, defined via
   the :ref:`API <breadcrumb-api>` or the
   :ref:`view helpers <breadcrumb-viewhelpers>`).


Automatic embedding of the breadcrumb markup into the page - Exclude additional doktypes
----------------------------------------------------------------------------------------

If the option :ref:`configuration-automaticBreadcrumbSchemaGeneration` is
enabled, you can define additional doktypes, which will be excluded from the
breadcrumb. Separate multiple doktypes with commas.

The doktypes 199 (spacer), 254 (folder) and 255 (recycler) are always excluded.

Default value
   (empty)


Allow only one breadcrumb list
------------------------------

With enabled option only one breadcrumb list will be rendered. This may be
helpful, if the option :ref:`configuration-automaticBreadcrumbSchemaGeneration`
is enabled and you want to overwrite the generated breadcrumb list on a
dedicated page with a custom one.


.. _configuration-embedMarkupInBodySection:

Embed markup in the body section
--------------------------------

If this option is enabled, the schema markup is embedded at the end of the
:html:`<body>` section. If it is disabled, it is embedded in the :html:`<head>`
section of the page.

Default value
   disabled

.. youtube:: lI6EtxjoyDU


.. _configuration-embedMarkupOnNoindexPages:

Embed markup on "noindex" pages
-------------------------------

If this option is enabled, the schema markup is embedded also on "noindex"
pages.

Default value
   enabled

.. note::
   The option is considered only if the :ref:`SEO system extension
   <typo3/cms-seo:introduction>` is installed. If this is not the case, the markup is
   always embedded.
