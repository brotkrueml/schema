# Structured data for TYPO3 with the schema extension

[![TYPO3](https://img.shields.io/badge/TYPO3-9%20LTS-orange.svg)](https://typo3.org/)

## Requirements

The extension works with TYPO3 9 LTS.

## Introduction

Structured data is essential for search engine optimisation nowadays. This extension 
allows the easy integration of structured data based on the [schema.org vocabulary](https://schema.org/)
on a TYPO3 website. A good introduction to the topic is provided by Google:
[Understand how structured data works](https://developers.google.com/search/docs/guides/intro-structured-data). 

The structured data is inserted on a web page in [JSON-LD](https://json-ld.org/) encoding 
and can be checked with Google's [Structured Data Testing Tool](https://search.google.com/structured-data/testing-tool).

Just a small desclaimer: Only accepted terms are available, [pending types and 
properties](https://pending.schema.org/) are not available. But if they are integrated
into the core vocabulary, they are available within the next update.

## Installation

### Installation With Composer

The recommended way to install this extension is by using Composer. In your Composer based TYPO3 project root, just type

    composer req brotkrueml/schema

### Installation As An Extension From The TYPO3 Extension Repository (TER)

(to be described)

## Usage

The structured data can be defined in two ways:

- via an API, e.g. in an Extbase controller
- with a view helper in a Fluid template

Each type in the schema.org vocabulary corresponds to a PHP model that provides the possible properties.
There is also a view helper for each type that makes it easy to integrate the data into your website.

### Using The API

Let's start with a simple example. Imagine you have some [person](https://schema.org/Person)
on a plugin's detail page page which you want to enrich with structured data. A good
place would be the show action of the controller. First you have to create the schema model:

    $person = new \Brotkrueml\Schema\Model\Type\Person();

Surely you'll have some properties to add, otherwise it makes no sense:

    $person
        ->setProperty('givenName', 'John')
        ->setProperty('familyName', 'Smith')
        ->setProperty('gender', 'http://schema.org/Male')
        ->setProperty('jobTitle', 'Software Developer')
    ;

That was easy ... let's go on and add the company for who the person works:

    $corporation = (new \Brotkrueml\Schema\Model\Type\Corporation())
        ->setProperty('name', 'Acme Ltd.')
        ->setProperty('image', 'https:/example.org/logo.png')
        ->setProperty('url', 'https://example.org/')
        ->setProperty('sameAs', 'https://twitter.com/example')
    ;

We have to connect the two types together:

    $person->setProperty('worksFor', $corporation);
    
Now we have the data defined. But how do we get them onto the webpage?
For that there is the schema manager:

    $schemaManager = TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \Brotkrueml\Schema\Manager\SchemaManager::class
    );
    $schemaManager->addType($person);

That's it ... if you call the according page the structured data are embedded
automatically into the head section:

    {
        "@context": "http://schema.org",
        "@type": "Person",
        "givenName": "John",
        "familyName": "Smith",
        "gender": "http://schema.org/Male",
        "jobTitle": "Software Developer",
        "worksFor": {
            "@type": "Corporation",
            "name": "Acme Ltd.",
            "image": "https://example.org/logo.png",
            "url": "https://example.org",
            "sameAs": "https://twitter.com/example"
         }
    }

### Using The View Helpers
 
#### Embedding View Helpers Into Another
 
Another possible way to insert the structured data is via a Fluid template:
 
    <schema:type.person
        givenName="John"
        familyName="Smith"
        gender="http://schema.org/Male"
        jobTitle="Software Developer"
    >
        <schema:type.corporation
            as="worksFor"
            name="Acme Ltd."
            image="https:/example.org/logo.png"
            url="https://example.org/"
            sameAs="https://twitter.com/example"
        />
    </schema:person>

The "as" property is a special property for the child where you can set the property for
the parent type.

#### Connecting Types Via -id Argument

But imagine, you have a page, where the corporation is described with many properties. And you
don't want to repeat the whole data for the corporation. Now comes the LD in JSON-LD into play.
The LD means "linked data".

You structure the data for the corporation:

         <schema:type.corporation
             -id="https://example.org/#corporation"
             name="Acme Ltd."
             image="https:/example.org/logo.png"
             url="https://example.org/"
             sameAs="https://twitter.com/example"
         />

You recognised the "id" property? This is a special one and is mapped in JSON-LD to "@id"
which is a unique IRI which represents this entity.

Now you can connect the corporation to the person:

     <schema:type.person
         givenName="John"
         familyName="Smith"
         gender="http://schema.org/Male"
         jobTitle="Software Developer"
     >
         <schema:type.corporation
             -as="worksFor"
             -id="https://example.org/#corporation"
         />
     </schema:person>

The resulting output would be now:

    [
        {
            "@context": "http://schema.org",
            "@type": "Corporation",
            "@id": "https://example.org/#corporation",
            "name": "Acme Ltd.",
            "image": "https://example.org/logo.png",
            "url": "https://example.org",
            "sameAs": "https://twitter.com/example"
        },
        {
            "@context": "http://schema.org",
            "@type": "Person",
            "givenName": "John",
            "familyName": "Smith",
            "gender": "http://schema.org/Male",
            "jobTitle": "Software Developer",
            "worksFor": {
                "@type": "Corporation",
                "@id": "https://example.org/#corporation"
        }
    }
]

#### Choosing A Specific Type

Sometimes it can may be needed to set a specific type. Imagine you'll have records of places where you can select
which type of specific place a record has: e.g. Museum, Airport, Park or Zoo. In a Fluid template you can loop over these records.
But it is not very convenient to use a switch view helper to choose the correct type. For this scenario you can benefit from a
feature:

    <schema:type.place
        name="Louvre"
        -specificType="Museum"
    /> 

#### Remarks About The Special Arguments

The dash as a suffix in the view helper argument signals that the argument is not an official one (-as, -specificType)
or has a special meaning (-id transforms to @id). So there should be no collisions with future properties of the schema.org
vocabulary.
