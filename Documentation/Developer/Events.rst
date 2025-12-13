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

The event allows to add markup in cases where no controller is available, for
example, if you want to enrich a page with structured data depending on the
doktype of a page.

The event :php:`\Brotkrueml\Schema\Event\RenderAdditionalTypesEvent`
provides the following methods:

.. confval:: getRequest(): \Psr\Http\Message\ServerRequestInterface
   :name: RenderAdditionalTypesEvent-getRequest

   Returns the PSR-7 request object.

.. confval:: addType(TypeInterface ...$type): void
   :name: RenderAdditionalTypesEvent-addType

   Add one or more type models.

.. confval:: addMainEntityOfWebPage(TypeInterface $mainEntity): void
   :name: RenderAdditionalTypesEvent-addMainEntityOfWebPage

   Add a :ref:`main entity <main-entity-of-web-page>`.

Example
~~~~~~~

In the following example we add structured data markup depending on the doktype
of the page:

.. literalinclude:: _Events/_AddMarkupToArticlePages.php
   :language: php
   :caption: EXT:my_extension/Classes/EventListener/AddMarkupToArticlePages.php

The method :php:`__invoke()` implements the logic for rendering additional
types. It receives the :php:`RenderAdditionalTypesEvent`. You can add as many
types as you like.


Prevent embedding of markup
===========================

.. versionadded:: 4.2.0

Sometimes it is required to disable the embedding of markup on certain pages.
If you have the need for that, the event
:php:`\Brotkrueml\Schema\Event\IsMarkupToBeInjectedEvent` is your friend.
The event is stoppable: the event listener that excludes the markup from
injection is the last one called in the chain.

The event provides the following methods:

.. confval:: getRequest(): \Psr\Http\Message\ServerRequestInterface
   :name: IsMarkupToBeInjectedEvent-getRequest

   Returns the PSR-7 request object.

.. confval:: excludeMarkupFromInjection(): void
   :name: IsMarkupToBeInjectedEvent-excludeMarkupFromInjection

   Method to be called, if you want to exclude a page from embedding the markup.

Example
~~~~~~~

The example excludes the markup from injection, if the page ID is 42:

.. literalinclude:: _Events/_ExcludeMarkupOnPage42.php
   :language: php
   :caption: EXT:my_extension/Classes/EventListener/ExcludeMarkupOnPage42.php


.. _pending: https://pending.schema.org/
.. _property annotations: https://schema.org/docs/actions.html#part-4
.. _PSR-14 Events in TYPO3: https://usetypo3.com/psr-14-events.html
