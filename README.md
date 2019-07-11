# Structured data for TYPO3 with the schema extension

[![TYPO3](https://img.shields.io/badge/TYPO3-9%20LTS-orange.svg)](https://typo3.org/)
[![Build Status](https://travis-ci.org/brotkrueml/schema.svg?branch=master)](https://travis-ci.org/brotkrueml/schema)
[![Maintainability Rating](https://sonarcloud.io/api/project_badges/measure?project=brotkrueml_schema&metric=sqale_rating)](https://sonarcloud.io/dashboard?id=brotkrueml_schema)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=brotkrueml_schema&metric=coverage)](https://sonarcloud.io/dashboard?id=brotkrueml_schema)
[![Latest Stable Version](https://poser.pugx.org/brotkrueml/schema/v/stable)](https://packagist.org/packages/brotkrueml/schema)


## Requirements

The extension works with TYPO3 9 LTS.


## Introduction

Structured data is essential for search engine optimisation nowadays. This extension 
allows the easy integration of structured data based on the [schema.org vocabulary](https://schema.org/)
on a TYPO3 website. A good introduction to the topic is provided by Google:
[Understand how structured data works](https://developers.google.com/search/docs/guides/intro-structured-data). 

The structured markup is inserted on a web page in [JSON-LD](https://json-ld.org/) encoding 
and can be checked with Google's [Structured Data Testing Tool](https://search.google.com/structured-data/testing-tool).


## Features

* Integrate structured schema.org markup into your website
  - with an PHP API
  - with Fluid view helpers
+ Configure the web page type in the page properties
* Well documented 


## Installation

### Installation With Composer

The recommended way to install this extension is by using Composer. In your Composer based TYPO3 project root, just type

    composer req brotkrueml/schema

### Installation As An Extension From The TYPO3 Extension Repository (TER)

You''ll find the extension also in the TYPO3 Extension Repository (link to be included).


## Documentation

The [documentation](https://docs.typo3.org/p/brotkrueml/schema/master/en-us/)
is comprehensive and covers the installation and configuration, and describes 
the usage of the API and the view helpers.

## Release Management

Schema uses semantic versioning which basically means for you, that

* Bugfix updates (e.g. 1.0.0 => 1.0.1) just includes small bug fixes or security relevant stuff without breaking changes.
* Minor updates (e.g. 1.0.0 => 1.1.0) includes new features and smaller tasks without breaking changes.
* Major updates (e.g. 1.0.0 => 2.0.0) breaking changes which can be refactorings, features or bug fixes.

