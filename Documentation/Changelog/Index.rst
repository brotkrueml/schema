.. _changelog:

Changelog
=========

All notable changes to this project will be documented in this file.

The format is based on `Keep a Changelog <https://keepachangelog.com/en/1.0.0/>`_\ , and this project adheres
to `Semantic Versioning <https://semver.org/spec/v2.0.0.html>`_.

`Unreleased <https://github.com/brotkrueml/schema/compare/v2.11.0...HEAD>`_
-------------------------------------------------------------------------------

`2.11.0 <https://github.com/brotkrueml/schema/compare/v2.10.0...v2.11.0>`_ - 2023-10-19
-------------------------------------------------------------------------------------------

Updated
^^^^^^^


* Schema definition to version 23.0

`2.10.0 <https://github.com/brotkrueml/schema/compare/v2.9.1...v2.10.0>`_ - 2023-07-21
------------------------------------------------------------------------------------------

Updated
^^^^^^^


* Schema definition to version 22.0

`2.9.1 <https://github.com/brotkrueml/schema/compare/v2.9.0...v2.9.1>`_ - 2023-06-06
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Custom page cache tags for schema page cache not considered (#115)

`2.9.0 <https://github.com/brotkrueml/schema/compare/v2.8.0...v2.9.0>`_ - 2023-06-02
----------------------------------------------------------------------------------------

Updated
^^^^^^^


* Schema definition to version 21.0

Fixed
^^^^^


* Hidden pages were referenced in automatic generated breadcrumb (#114)
* Disabled pages in menu were referenced in automatic generated breadcrumb

`2.8.0 <https://github.com/brotkrueml/schema/compare/v2.7.2...v2.8.0>`_ - 2023-05-22
----------------------------------------------------------------------------------------

Updated
^^^^^^^


* Schema definition to version 19.0

`2.7.2 <https://github.com/brotkrueml/schema/compare/v2.7.1...v2.7.2>`_ - 2023-04-26
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Deprecation notice for items configuration in TCA select field in TYPO3 v12

`2.7.1 <https://github.com/brotkrueml/schema/compare/v2.7.0...v2.7.1>`_ - 2023-02-24
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Avoid error when SchemaManager is called via view helpers in backend context (#108)

`2.7.0 <https://github.com/brotkrueml/schema/compare/v2.6.4...v2.7.0>`_ - 2023-02-14
----------------------------------------------------------------------------------------

Added
^^^^^


* Configuration option to allow only one breadcrumb list (#104)

`2.6.4 <https://github.com/brotkrueml/schema/compare/v2.6.3...v2.6.4>`_ - 2023-01-05
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Avoid deprecation in admin panel for PHP 8.2

`2.6.3 <https://github.com/brotkrueml/schema/compare/v2.6.2...v2.6.3>`_ - 2022-12-09
----------------------------------------------------------------------------------------

Fixed
^^^^^


* "Cannot call constructor" error in admin panel with TYPO3 v12.1 (#103)

`2.6.2 <https://github.com/brotkrueml/schema/compare/v2.6.1...v2.6.2>`_ - 2022-11-15
----------------------------------------------------------------------------------------

Fixed
^^^^^


* "CacheManager can not be injected" error in custom functional tests when using typo3/testing-framework (#102)

`2.6.1 <https://github.com/brotkrueml/schema/compare/v2.6.0...v2.6.1>`_ - 2022-10-28
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Rich Snippet Tool interprets FAQPage in breadcrumb wrong (#101)

`2.6.0 <https://github.com/brotkrueml/schema/compare/v2.5.2...v2.6.0>`_ - 2022-10-04
----------------------------------------------------------------------------------------

Added
^^^^^


* Compatibility with TYPO3 v12 (#99)

`2.5.2 <https://github.com/brotkrueml/schema/compare/v2.5.1...v2.5.2>`_ - 2022-09-02
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Property with only @id as value not displayed in AdminPanel (#98)

`2.5.1 <https://github.com/brotkrueml/schema/compare/v2.5.0...v2.5.1>`_ - 2022-06-13
----------------------------------------------------------------------------------------

Security
^^^^^^^^


* Properly escape content

`2.5.0 <https://github.com/brotkrueml/schema/compare/v2.4.0...v2.5.0>`_ - 2022-05-18
----------------------------------------------------------------------------------------

Added
^^^^^


* Assign multiple values to one property via TypoScript

Fixed
^^^^^


* Usage of stdWrap in combination with a string property value in TypoScript configuration

`2.4.0 <https://github.com/brotkrueml/schema/compare/v2.3.0...v2.4.0>`_ - 2022-03-28
----------------------------------------------------------------------------------------

Updated
^^^^^^^


* Schema definition to version 14.0

`2.3.0 <https://github.com/brotkrueml/schema/compare/v2.2.2...v2.3.0>`_ - 2022-02-28
----------------------------------------------------------------------------------------

Added
^^^^^


* Configuration option to exclude custom doktypes when automatically generating the breadcrumb (#84)
* Content Object (cObject) ``SCHEMA`` to add types via TypoScript (#88)
  Thanks to `Daniel Siepmann <https://daniel-siepmann.de/about-me.html>`_

`2.2.2 <https://github.com/brotkrueml/schema/compare/v2.2.1...v2.2.2>`_ - 2022-01-02
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Empty property values in Admin Panel for multiple types

`2.2.1 <https://github.com/brotkrueml/schema/compare/v2.2.0...v2.2.1>`_ - 2021-11-20
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Error in Admin Panel when a property has a URL as value without path

`2.2.0 <https://github.com/brotkrueml/schema/compare/v2.1.0...v2.2.0>`_ - 2021-11-17
----------------------------------------------------------------------------------------

Added
^^^^^


* Prioritisation of main entities (#77)

`2.1.0 <https://github.com/brotkrueml/schema/compare/v2.0.2...v2.1.0>`_ - 2021-10-19
----------------------------------------------------------------------------------------

Added
^^^^^


* List of available schema.org types in Configuration module (only TYPO3 v11+) (#74)

Fixed
^^^^^


* Type error in PaddingViewHelper with activated Admin Panel (#76)

`2.0.2 <https://github.com/brotkrueml/schema/compare/v2.0.1...v2.0.2>`_ - 2021-09-15
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Display field "Type of web page" in page properties for noindex pages

`2.0.1 <https://github.com/brotkrueml/schema/compare/v2.0.0...v2.0.1>`_ - 2021-08-09
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Avoid error in Rich Result Test when validating JSON-LD via Admin Panel

`2.0.0 <https://github.com/brotkrueml/schema/compare/v1.12.0...v2.0.0>`_ - 2021-08-01
-----------------------------------------------------------------------------------------

Added
^^^^^


* Node identifier and blank node identifier (#65, #67)
* Multiple types for a node (#64, #68)

Changed
^^^^^^^


* Context moved from http://schema.org to https://schema.org/ (#58)
* By default, markup is added to noindex pages, a configuration setting is available for deactivation (#60)

Fixed
^^^^^


* Custom doktypes greater than 199 are rendered in breadcrumb list

Removed
^^^^^^^


* Compatibility with TYPO3 v9 LTS (#41)
* Compatibility with PHP 7.2 and PHP 7.3 (#42)
* The PSR-14 event and signal for (de)activating the embedding of markup are removed (#60)
* Signal/slots in favour of PSR-14 events (#43)
* Deprecated methods AbstractType->isEmpty() and SchemaManager->setMainEntityOfWebPage() (#44)
* Deprecated class TypesProvider (#44)

`1.13.2 <https://github.com/brotkrueml/schema/compare/v1.13.1...v1.13.2>`_ - 2022-10-28
-------------------------------------------------------------------------------------------

Fixed
^^^^^


* Rich Snippet Tool interprets FAQPage in breadcrumb wrong (#101)

`1.13.1 <https://github.com/brotkrueml/schema/compare/v1.13.0...v1.13.1>`_ - 2022-06-13
-------------------------------------------------------------------------------------------

Security
^^^^^^^^


* Properly escape content

`1.13.0 <https://github.com/brotkrueml/schema/compare/v1.12.1...v1.13.0>`_ - 2022-03-28
-------------------------------------------------------------------------------------------

Updated
^^^^^^^


* Schema definition to version 14.0

`1.12.1 <https://github.com/brotkrueml/schema/compare/v1.12.0...v1.12.1>`_ - 2021-08-09
-------------------------------------------------------------------------------------------

Fixed
^^^^^


* Avoid error in Rich Result Test when validating JSON-LD via Admin Panel

`1.12.0 <https://github.com/brotkrueml/schema/compare/v1.11.1...v1.12.0>`_ - 2021-07-07
-------------------------------------------------------------------------------------------

Updated
^^^^^^^


* Schema definition to version 13.0

Changed
^^^^^^^


* Move from Structured Data Testing Tool to Schema Markup Validator in Admin Panel (#66)

Fixed
^^^^^


* PHP 8.0 issues
* Link images with extension in uppercase in Admin Panel (#69)
* Ignore an empty array for a property value when rendering JSON-LD

`1.11.1 <https://github.com/brotkrueml/schema/compare/v1.11.0...v1.11.1>`_ - 2021-04-06
-------------------------------------------------------------------------------------------

Fixed
^^^^^


* Add missing properties for types Pharmacy and Physician
* Allow value "0" in PropertyViewHelper

`1.11.0 <https://github.com/brotkrueml/schema/compare/v1.10.0...v1.11.0>`_ - 2021-03-10
-------------------------------------------------------------------------------------------

Updated
^^^^^^^


* Schema definition to version 12.0 (#3)

`1.10.0 <https://github.com/brotkrueml/schema/compare/v1.9.0...v1.10.0>`_ - 2020-12-28
------------------------------------------------------------------------------------------

Added
^^^^^


* Compatibility with TYPO3 v11

Updated
^^^^^^^


* Schema definition to version 11.01 (#3)

Changed
^^^^^^^


* Raise minimum required version to TYPO3 9.5.16

`1.9.0 <https://github.com/brotkrueml/schema/compare/v1.8.0...v1.9.0>`_ - 2020-09-08
----------------------------------------------------------------------------------------

Added
^^^^^


* Button in Admin Panel to verify structured data in Rich Result Test

Updated
^^^^^^^


* Schema definition to version 10.0 (#3)

`1.8.0 <https://github.com/brotkrueml/schema/compare/v1.7.2...v1.8.0>`_ - 2020-07-08
----------------------------------------------------------------------------------------

Added
^^^^^


* Display schema markup of a page in the Admin Panel (#49)

`1.7.2 <https://github.com/brotkrueml/schema/compare/v1.7.1...v1.7.2>`_ - 2020-06-14
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Remove usage of PHP 8.0 functions, as polyfill is not available in classic installation

`1.7.1 <https://github.com/brotkrueml/schema/compare/v1.7.0...v1.7.1>`_ - 2020-05-26
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Generate types in view helpers inside "for" loop correctly (#52)

`1.7.0 <https://github.com/brotkrueml/schema/compare/v1.6.0...v1.7.0>`_ - 2020-04-22
----------------------------------------------------------------------------------------

Added
^^^^^


* Possibility to register additional schema types (#38)
* Introduce a TypeInterface for type models implementations
* Introduce a TypeFactory for creating type models (#48)

Updated
^^^^^^^


* Schema definition to version 7.04 (#3)

Changed
^^^^^^^


* Decouple rendering of JSON-LD from AbstractType and SchemaManager
* Move decision about embedding markup into event listener
* Support only TYPO3 LTS versions

Deprecated
^^^^^^^^^^


* TypesProvider in favour of TypeRegistry (which now is a singleton)
* AbstractType->isEmpty()

`1.6.0 <https://github.com/brotkrueml/schema/compare/v1.5.2...v1.6.0>`_ - 2020-03-09
----------------------------------------------------------------------------------------

Added
^^^^^


* Possibility to register additional type properties (#36)
* Allow boolean property values which are mapped to http://schema.org/True / http://schema.org/False (#37)
* Add translations from Crowdin

Changed
^^^^^^^


* Adapt properties management in type models

`1.5.2 <https://github.com/brotkrueml/schema/compare/v1.5.1...v1.5.2>`_ - 2020-02-09
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Correct sorting of rootline during automatic breadcrumb generation (#32)

`1.5.1 <https://github.com/brotkrueml/schema/compare/v1.5.0...v1.5.1>`_ - 2020-01-30
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Remove doubled base URL in id of list item in BreadcrumbViewHelper (#31)

`1.5.0 <https://github.com/brotkrueml/schema/compare/v1.4.2...v1.5.0>`_ - 2020-01-22
----------------------------------------------------------------------------------------

Added
^^^^^


* Add Signal/PSR-14 event to decide about embedding of markup (#29)

Updated
^^^^^^^


* Schema definition to version 6.0 (#3)

`1.4.2 <https://github.com/brotkrueml/schema/compare/v1.4.1...v1.4.2>`_ - 2019-12-13
----------------------------------------------------------------------------------------

Changed
^^^^^^^


* Remove middlewares in favour of aspects

Fixed
^^^^^


* Markup is not lost anymore when non-cached plugin on page (#27)
* Don't show special doktypes in BreadcrumbList (#28)

`1.4.1 <https://github.com/brotkrueml/schema/compare/v1.4.0...v1.4.1>`_ - 2019-12-01
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Handle multiple items in mainEntity as array defined in WebPage correctly (#25)

Deprecated
^^^^^^^^^^


* SchemaManager->setMainEntityOfWebPage() in favour of SchemaManager->addMainEntityOfWebPage() (#25)

`1.4.0 <https://github.com/brotkrueml/schema/compare/v1.3.1...v1.4.0>`_ - 2019-11-23
----------------------------------------------------------------------------------------

Changed
^^^^^^^


* Multiple items in mainEntity of a WebPage (#25)

Updated
^^^^^^^


* Schema definition to version 5.0 (#3)

`1.3.1 <https://github.com/brotkrueml/schema/compare/v1.3.0...v1.3.1>`_ - 2019-11-04
----------------------------------------------------------------------------------------

Changed
^^^^^^^


* Use Dependency Injection for TYPO3 v10 with fallback for v9

Fixed
^^^^^


* Type value of 0.00 is not rendered when used in view helper (#23)

`1.3.0 <https://github.com/brotkrueml/schema/compare/v1.2.0...v1.3.0>`_ - 2019-09-28
----------------------------------------------------------------------------------------

Added
^^^^^


* Configuration option for automatic embedding of a breadcrumb in pages (#20)
* Choice where to place markup: head or body section (#21)
* API for retrieving lists of types (#19)

`1.2.0 <https://github.com/brotkrueml/schema/compare/v1.1.0...v1.2.0>`_ - 2019-09-03
----------------------------------------------------------------------------------------

Added
^^^^^


* Don't embed schema markup when page should not be indexed by search engines (#18)
* Use @graph when multiple types on root level (#17)

Changed
^^^^^^^


* Use interface to identify a WebPage type model

`1.1.0 <https://github.com/brotkrueml/schema/compare/v1.0.0...v1.1.0>`_ - 2019-07-27
----------------------------------------------------------------------------------------

Added
^^^^^


* Support for TYPO3 10.0

Changed
^^^^^^^


* Set classes as final (where appropriate), adjust visibility of properties

`1.0.0 <https://github.com/brotkrueml/schema/compare/v0.9.0...v1.0.0>`_ - 2019-07-11
----------------------------------------------------------------------------------------

First stable release

Added
^^^^^


* Hint in documentation to XSD schema of view helpers

`0.9.0 <https://github.com/brotkrueml/schema/compare/v0.8.1...v0.9.0>`_ - 2019-07-10
----------------------------------------------------------------------------------------

Changed
^^^^^^^


* Rename method getProperties() to getPropertyNames() in AbstractType class

Fixed
^^^^^


* Allow null as property value (this is also the default value after instantiation of a type model)
* Do not render a property with an empty string

`0.8.1 <https://github.com/brotkrueml/schema/compare/v0.8.0...v0.8.1>`_ - 2019-07-09
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Check, if given breadcrumb item is an array in BreadcrumbViewHelper

`0.8.0 <https://github.com/brotkrueml/schema/compare/v0.7.0...v0.8.0>`_ - 2019-07-09
----------------------------------------------------------------------------------------

Changed
^^^^^^^


* Add possibility to overwrite web page type in another language

`0.7.0 <https://github.com/brotkrueml/schema/compare/v0.6.0...v0.7.0>`_ - 2019-07-08
----------------------------------------------------------------------------------------

Added
^^^^^


* The mainEntity property can be set via the SchemaManager or the type view helpers (#14)

Changed
^^^^^^^


* Add conflict with extension brotkrueml/sdbreadcrumb

Fixed
^^^^^


* Type with only empty properties should be rendered (#15)

`0.6.0 <https://github.com/brotkrueml/schema/compare/v0.5.0...v0.6.0>`_ - 2019-07-04
----------------------------------------------------------------------------------------

Added
^^^^^


* Allow all numeric values as property value
* Initial documentation in reST format (#9)

`0.5.0 <https://github.com/brotkrueml/schema/compare/v0.4.0...v0.5.0>`_ - 2019-07-03
----------------------------------------------------------------------------------------

Added
^^^^^


* Add method for setting different properties at once for a type (#12)

Changed
^^^^^^^


* Check if at least one property of a type is filled (#13)
* Mark some methods as internal

`0.4.0 <https://github.com/brotkrueml/schema/compare/v0.3.0...v0.4.0>`_ - 2019-06-30
----------------------------------------------------------------------------------------

Added
^^^^^


* BreadcrumbLists can be handled by SchemaManager (#2)
* Possibility to assign the same property multiple times in a view helper (#8)

`0.3.0 <https://github.com/brotkrueml/schema/compare/v0.2.0...v0.3.0>`_ - 2019-06-29
----------------------------------------------------------------------------------------

Fixed
^^^^^


* Assigning multiple sub types in Fluid throwed error (#7)

`0.2.0 <https://github.com/brotkrueml/schema/compare/v0.1.0...v0.2.0>`_ - 2019-06-28
----------------------------------------------------------------------------------------

Added
^^^^^


* Specific type of WebPage can be selected in page properties (#1)

`0.1.0 <https://github.com/brotkrueml/schema/releases/tag/v0.1.0>`_ - 2019-06-25
------------------------------------------------------------------------------------

Initial release

Added
^^^^^


* API for adding schema.org vocabulary to a website
* View helpers for usage in Fluid templates
