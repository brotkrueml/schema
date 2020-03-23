# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Possibility to register additional schema types (#38)

### Deprecated
- TypesProvider in favour of TypeRegistry (which now is a singleton)

## [1.6.0] - 2020-03-09

### Added
- Possibility to register additional type properties (#36)
- Allow boolean property values which are mapped to http://schema.org/True / http://schema.org/False (#37)
- Add translations from Crowdin

### Changed
- Adapt properties management in type models

## [1.5.2] - 2020-02-09

### Fixed
- Correct sorting of rootline during automatic breadcrumb generation (#32)

## [1.5.1] - 2020-01-30

### Fixed
- Remove doubled base URL in id of list item in BreadcrumbViewHelper (#31)

## [1.5.0] - 2020-01-22

### Added
- Add Signal/PSR-14 event to decide about embedding of markup (#29)
- Update schema definition to version 6.0 (#3)

## [1.4.2] - 2019-12-13

### Changed
- Remove middlewares in favour of aspects

### Fixed
- Markup is not lost anymore when non-cached plugin on page (#27)
- Don't show special doktypes in BreadcrumbList (#28)

## [1.4.1] - 2019-12-01

### Fixed
- Handle multiple items in mainEntity as array defined in WebPage correctly (#25)

### Deprecated
- SchemaManager->setMainEntityOfWebPage() in favour of SchemaManager->addMainEntityOfWebPage() (#25)

## [1.4.0] - 2019-11-23

### Changed
- Multiple items in mainEntity of a WebPage (#25)
- Update schema definition to version 5.0 (#3)

## [1.3.1] - 2019-11-04

### Changed
- Use Dependency Injection for TYPO3 v10 with fallback for v9

### Fixed
- Type value of 0.00 is not rendered when used in view helper (#23)

## [1.3.0] - 2019-09-28

### Added
- Configuration option for automatic embedding of a breadcrumb in pages (#20)
- Choice where to place markup: head or body section (#21)
- API for retrieving lists of types (#19)

## [1.2.0] - 2019-09-03

### Added
- Don't embed schema markup when page should not be indexed by search engines (#18)
- Use @graph when multiple types on root level (#17)

### Changed
- Use interface to identify a WebPage type model

## [1.1.0] - 2019-07-27

### Added
- Support for TYPO3 10.0

### Changed
- Set classes as final (where appropriate), adjust visibility of properties

## [1.0.0] - 2019-07-11

First stable release

### Added
- Hint in documentation to XSD schema of view helpers

## [0.9.0] - 2019-07-10

### Changed
- Rename method getProperties() to getPropertyNames() in AbstractType class

### Fixed
- Allow null as property value (this is also the default value after instantiation of a type model)
- Do not render a property with an empty string

## [0.8.1] - 2019-07-09

### Fixed
- Check, if given breadcrumb item is an array in BreadcrumbViewHelper

## [0.8.0] - 2019-07-09

### Changed
- Add possibility to overwrite web page type in another language

## [0.7.0] - 2019-07-08

### Added
- The mainEntity property can be set via the SchemaManager or the type view helpers (#14)

### Changed
- Add conflict with extension brotkrueml/sdbreadcrumb

### Fixed
- Type with only empty properties should be rendered (#15)

## [0.6.0] - 2019-07-04

### Added
- Allow all numeric values as property value
- Initial documentation in reST format (#9)

## [0.5.0] - 2019-07-03

### Added
- Add method for setting different properties at once for a type (#12)

### Changed
- Check if at least one property of a type is filled (#13)
- Mark some methods as internal

## [0.4.0] - 2019-06-30

### Added
- BreadcrumbLists can be handled by SchemaManager (#2)
- Possibility to assign the same property multiple times in a view helper (#8)

## [0.3.0] - 2019-06-29

### Fixed
- Assigning multiple sub types in Fluid throwed error (#7)

## [0.2.0] - 2019-06-28

### Added
- Specific type of WebPage can be selected in page properties (#1)

## [0.1.0] - 2019-06-25

Initial release

### Added
- API for adding schema.org vocabulary to a website
- View helpers for usage in Fluid templates


[Unreleased]: https://github.com/brotkrueml/schema/compare/v1.6.0...HEAD
[1.6.0]: https://github.com/brotkrueml/schema/compare/v1.5.2...v1.6.0
[1.5.2]: https://github.com/brotkrueml/schema/compare/v1.5.1...v1.5.2
[1.5.1]: https://github.com/brotkrueml/schema/compare/v1.5.0...v1.5.1
[1.5.0]: https://github.com/brotkrueml/schema/compare/v1.4.2...v1.5.0
[1.4.2]: https://github.com/brotkrueml/schema/compare/v1.4.1...v1.4.2
[1.4.1]: https://github.com/brotkrueml/schema/compare/v1.4.0...v1.4.1
[1.4.0]: https://github.com/brotkrueml/schema/compare/v1.3.1...v1.4.0
[1.3.1]: https://github.com/brotkrueml/schema/compare/v1.3.0...v1.3.1
[1.3.0]: https://github.com/brotkrueml/schema/compare/v1.2.0...v1.3.0
[1.2.0]: https://github.com/brotkrueml/schema/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/brotkrueml/schema/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/brotkrueml/schema/compare/v0.9.0...v1.0.0
[0.9.0]: https://github.com/brotkrueml/schema/compare/v0.8.1...v0.9.0
[0.8.1]: https://github.com/brotkrueml/schema/compare/v0.8.0...v0.8.1
[0.8.0]: https://github.com/brotkrueml/schema/compare/v0.7.0...v0.8.0
[0.7.0]: https://github.com/brotkrueml/schema/compare/v0.6.0...v0.7.0
[0.6.0]: https://github.com/brotkrueml/schema/compare/v0.5.0...v0.6.0
[0.5.0]: https://github.com/brotkrueml/schema/compare/v0.4.0...v0.5.0
[0.4.0]: https://github.com/brotkrueml/schema/compare/v0.3.0...v0.4.0
[0.3.0]: https://github.com/brotkrueml/schema/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/brotkrueml/schema/compare/v0.1.0...v0.2.0
[0.1.0]: https://github.com/brotkrueml/schema/releases/tag/v0.1.0
