.. include:: ../Includes.txt


.. _introduction:

============
Introduction
============


.. _what-it-does:

What does it do?
================

Structured data is essential for search engine optimisation nowadays. This extension allows the easy integration of
structured data based on the `schema.org vocabulary <https://schema.org/>`__ on a TYPO3 website. A good introduction to the topic is provided
by Google: `Understand how structured data works <https://developers.google.com/search/docs/guides/intro-structured-data>`__.

The defined structured data is embedded on a web page in `JSON-LD <https://json-ld.org/>`__ markup and can be checked with
Google's `Structured Data Testing Tool <https://search.google.com/structured-data/testing-tool>`__.

There are also browser extensions available which ease the testing of the markup, e.g.
`Structured Data Testing Tool <https://chrome.google.com/webstore/detail/structured-data-testing-t/kfdjeigpgagildmolfanniafmplnplpl>`__
for Chrome.

For the differences between the versions have a look at the `change log <https://github.com/brotkrueml/schema/blob/master/CHANGELOG.md>`__.

Current limitations
===================

For now, only accepted terms are available, the usage of `pending types and properties <https://pending.schema.org/>`__
is not possible. But if they are integrated into the core vocabulary, they are available within the next update.
