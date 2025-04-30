.. include:: /Includes.rst.txt

.. _events:

=============
PSR-14 events
=============

Target group: **Developers**

.. contents:: Table of Contents
   :depth: 2
   :local:

Introduction
============

You can enhance the functionality in the schema extension with PSR-14 event
listeners. An event listener receives an event that provides methods for
retrieving and setting dedicated properties.

.. seealso::
   You can find more information about PSR-14 events in the blog article
   `PSR-14 Events in TYPO3`_ and the official :ref:`TYPO3 documentation
   <t3coreapi:EventDispatcher>`.


.. _event-render-additional-types:

Render additional types
=======================

.. versionchanged:: 3.11.0
   This event is available in older versions, but is now official API.

The event allows to add markup in cases where no controller is available, for
example, if you want to enrich a page with structured data depending on the
doktype of a page.

The event :php:`\Brotkrueml\Schema\Event\RenderAdditionalTypesEvent`
provides the following methods:

.. option:: getRequest(): \Psr\Http\Message\ServerRequestInterface

   Returns the PSR-7 request object.

.. option:: addType(TypeInterface ...$type): void

   Add one or more type models.

.. option:: addMainEntityOfWebPage(TypeInterface $mainEntity): void

   Add a :ref:`main entity <main-entity-of-web-page>`.

Example
~~~~~~~

In the example we add structured data markup depending on the doktype of the
page.

.. rst-class:: bignums-xxl

#. Create the event listener

   .. literalinclude:: _Events/_AddMarkupToArticlePages.php
      :language: php
      :caption: EXT:my_extension/Classes/EventListener/AddMarkupToArticlePages.php

   The method :php:`__invoke()` implements the logic for rendering additional
   types. It receives the :php:`RenderAdditionalTypesEvent`. You can add as many
   types as you like.

#. Register your event listener in :file:`Configuration/Services.yaml`

   .. code-block:: yaml

      services:
         # Place here the default dependency injection configuration

         MyVendor\MyExtension\EventListener\AddMarkupToArticlePages:
            tags:
               - name: event.listener
                 identifier: 'my-extension/add-markup-to-article-pages'

Read :ref:`how to configure dependency injection in extensions <t3coreapi:dependency-injection-in-extensions>`.


.. _pending: https://pending.schema.org/
.. _property annotations: https://schema.org/docs/actions.html#part-4
.. _PSR-14 Events in TYPO3: https://usetypo3.com/psr-14-events.html
