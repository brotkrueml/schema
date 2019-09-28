# Changelog
All notable changes to this project will be documented in this file. This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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


[Unreleased]: https://github.com/brotkrueml/schema/compare/v1.3.0...HEAD
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
