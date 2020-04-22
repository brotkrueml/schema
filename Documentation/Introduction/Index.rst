.. include:: ../Includes.txt


.. _introduction:

============
Introduction
============

.. contents:: Table of Contents
   :depth: 1
   :local:

.. _what-it-does:

What does it do?
================

Structured data is essential for search engine optimisation nowadays. This
extension allows the easy integration of structured data based on the
`schema.org vocabulary <https://schema.org/>`__ on a TYPO3 website. A good
introduction to the topic is provided by Google:
`Understand how structured data works <https://developers.google.com/search/docs/guides/intro-structured-data>`__.

The defined structured data is embedded on a web page in
`JSON-LD <https://json-ld.org/>`__ markup and can be checked with Google's
`Structured Data Testing Tool <https://search.google.com/structured-data/testing-tool>`__
and `Rich Results Test <https://search.google.com/test/rich-results>`__.

There are also browser extensions available which ease the testing of the
markup, e.g.
`Structured Data Testing Tool <https://chrome.google.com/webstore/detail/structured-data-testing-t/kfdjeigpgagildmolfanniafmplnplpl>`__
for Chrome.

For the differences between the versions have a look at the
`change log <https://github.com/brotkrueml/schema/blob/master/CHANGELOG.md>`__.

.. tip::

   There is a Slack channel #ext-schema on `typo3.slack.com
   <https://typo3.slack.com/>`__ for questions, suggestions, feedback, etc.


.. _limitations:

Current limitations
===================

For now, only accepted terms are available, the usage of
`pending types and properties <https://pending.schema.org/>`__ is not possible.
But if they are integrated into the core vocabulary, they are available within
the next update. Also extensions, like bib or health, are not included.

If you need custom properties (like pending properties) you may use a
:ref:`slot/PSR-14 event <event-register-additional-properties>` to register them
to one or more types.


.. _release-management:

Release management
==================

This extension uses `semantic versioning <https://semver.org/>`__ which
basically means for you, that

* Bugfix updates (e.g. 1.0.0 => 1.0.1) just includes small bug fixes or security
  relevant stuff without breaking changes.
* Minor updates (e.g. 1.0.0 => 1.1.0) includes new features and smaller tasks
  without breaking changes.
* Major updates (e.g. 1.0.0 => 2.0.0) breaking changes which can be
  refactorings, features or bug fixes.
