# Structured data for TYPO3 with the schema extension

[![TYPO3](https://img.shields.io/badge/TYPO3-9%20LTS-orange.svg)](https://typo3.org/)
[![Build Status](https://travis-ci.org/brotkrueml/schema.svg?branch=master)](https://travis-ci.org/brotkrueml/schema)
[![Latest Stable Version](https://poser.pugx.org/brotkrueml/schema/v/stable)](https://packagist.org/packages/brotkrueml/schema)

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
properties](https://pending.schema.org/) are not available yet. But if they are integrated
into the core vocabulary, they are available within the next update.

## Installation

### Installation With Composer

The recommended way to install this extension is by using Composer. In your Composer based TYPO3 project root, just type

    composer req brotkrueml/schema

### Installation As An Extension From The TYPO3 Extension Repository (TER)

(to be described)

## Configuration

Currently there is one extension configuration setting available:

```basic.automaticWebPageSchemaGeneration```: If this option is activated (the default) the [WebPage](https://schema.org/WebPage)
type schema is automatically inserted into the page if the web page type is not set manually via the API or the view helper.
The value of the page field "Specific type of web page" is used as type. The type properties ```name``` (from page title),
```description``` (from page description) and ```expires``` (only if page endtime is set) are defined.

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
    ;

That was easy ... let's go on and add the company for who the person works:

    $corporation = (new \Brotkrueml\Schema\Model\Type\Corporation())
        ->setProperty('name', 'Acme Ltd.')
        ->setProperty('image', 'https:/example.org/logo.png')
        ->setProperty('url', 'https://example.org/')
        ->setProperty('sameAs', 'https://twitter.com/example')
        ->addProperty('sameAs', 'https://facebook.com/example')
    ;

We have to connect the two types together:

    $person->setProperty('worksFor', $corporation);
    
Now we have the data defined. But how do we get them onto the webpage?
For that there is the schema manager:

    $schemaManager = TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \Brotkrueml\Schema\Manager\SchemaManager::class
    );
    $schemaManager->addType($person);

That's it ... if you call the according page the structured data is embedded
automatically into the head section:

    {
        "@context": "http://schema.org",
        "@type": "Person",
        "givenName": "John",
        "familyName": "Smith",
        "gender": "http://schema.org/Male",
        "worksFor": {
            "@type": "Corporation",
            "name": "Acme Ltd.",
            "image": "https://example.org/logo.png",
            "url": "https://example.org",
            "sameAs": ["https://twitter.com/example", "https://facebook.com/example"]
         }
    }

#### WebPage

The type [WebPage](https://schema.org/WebPage) and its descendants (like [AboutPage](https://schema.org/AboutPage)
or [ImageGallery](https://schema.org/ImageGallery)) are a little bit special because they can only
appear once on a web page. You can define it with the API:

    $webPage = (new \Brotkrueml\Schema\Model\Type\WebPage())
        ->setProperty('name', 'The title of the web page')
        ->setProperty('description', 'The description of the web page')
        ->setProperty('primaryImageOfPage', 'https://example.org/image.png')
    ;
    
    $schemaManager->addType($webPage);

You can set the web page multiple times, the last one wins. If no web page is defined (and the
according configuration setting is activated), a default web page type is created which sets the
name (from the page title) and the description (from the page description).

### Using The View Helpers
 
#### Embedding View Helpers Into Another
 
Another possible way to insert the structured data is via a Fluid template:
 
    <schema:type.person
        givenName="John"
        familyName="Smith"
        gender="http://schema.org/Male"
    >
        <schema:type.corporation
            -as="worksFor"
            name="Acme Ltd."
            image="https://example.org/logo.png"
            url="https://example.org/">
                <schema:property -as="sameAs" value="https://twitter.com/example"/>
                <schema:property -as="sameAs" value="https://facebook.com/example"/>
        </schema:type.corporation>
    </schema:type.person>

The "-as" property is a special property for the child where you can set the property for
the parent type.

Please recognise the usage of the ```<schema:property/>``` view helper. You can use this
when assigning more than one string value to a property.

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

The dash as a suffix in the view helper argument signals that the argument is not an official schema.org property (-as, -specificType)
or has a special meaning (-id transforms to @id). So there should be no collisions with future properties of the schema.org
vocabulary.

#### WebPage

It is possible to set the WebPage type or one of it descendants with a view helper, e.g. in a Fluid layout:

    <schema:type.webPage
        name="The title of the web page"
        description="The description of the web page"
        primaryImageOfPage="https://example.org/image.png"
    />

or in a News single template (together with the property mainEntity):

    <schema:type.itemPage
        name="The title of the item page"
        description="The description of the item page"
    >
        <schema:type.article
            -as="mainEntity"
            -id="http://example.org/#news-42"
            headline="The headline of the news item"
            image="http://example.org/image.png"
            datePublished="2019-06-25"
        >
            <schema:type.person
                -as="author"
                -id="http://example.org/#john-doe"
                name="John Doe"
            />
            <schema:type.person
                -as="author"
                -id="http://example.org/#jan-novak"
                name="Jan Novak"
            />
        </schema:type.article>
    </schema:type.itemPage>

As you can see in this example, you can embed type in type in type (and so on) and also assign the same property (author)
multiple times with different values.

#### Breadcrumb

A breadcrumb is an essential part of a web page. It gives an user an idea where on the web site he is.
He can also navigate to previous pages. But for search engines a breadcrumb is also essential to understand
the structure of a web site. Last but not least, the breadcrumb is shown in the search result snippet if
structured markup for the breadcrumb is available.

There can also be more than one breadcrumb on a page, Google gives an example in his guidelines for a
[breadcrumb](https://developers.google.com/search/docs/data-types/breadcrumb).

You can generate a breadcrumb with the available view helpers of this extension:

    <schema:type.breadcrumbList>
        <schema:type.listItem -as="itemListElement" name="Page 1" item="https://example.org/page-1/" position="1"/>
        <schema:type.listItem -as="itemListElement" name="Page 2" item="https://example.org/page-1/page-2/" position="2"/>
        <schema:type.listItem -as="itemListElement" name="Page 3" item="https://example.org/page-1/page-2/page-3/" position="3"/>
    </schema:type.breadcrumbList>

Or a more complex example which respects the web page type:

    <schema:type.breadcrumbList>
        <schema:type.listItem -as="itemListElement" name="Page 1" position="1">
            <schema:type.webPage -as="item" -id="https://example.org/page-1/"/>
        </schema:type.listItem>
        <schema:type.listItem -as="itemListElement" name="Page 2" position="2">
            <schema:type.collectionPage -as="item" -id="https://example.org/page-1/page-2/"/>
        </schema:type.listItem>
        <schema:type.listItem -as="itemListElement" name="Page 3" position="3">
            <schema:type.itemPage -as="item" -id="https://example.org/page-1/page-2/page-3/"/>
        </schema:type.listItem>
    </schema:type.breadcrumbList>

It is also possible to use it in combination with a WebPage:

    <schema:type.itemPage>
        <schema:type.organization -as="publisher" name="Acme Ltd."/>
        <schema:type.breadcrumbList -as="breadcrumb">
            <schema:type.listItem -as="itemListElement" name="Page 1" position="1">
                <schema:type.webPage -as="item" -id="https://example.org/page-1/"/>
            </schema:type.listItem>
            <schema:type.listItem -as="itemListElement" name="Page 2" position="2">
                <schema:type.collectionPage -as="item" -id="https://example.org/page-1/page-2/"/>
            </schema:type.listItem>
            <schema:type.listItem -as="itemListElement" name="Page 3" position="3">
                <schema:type.itemPage -as="item" -id="https://example.org/page-1/page-2/page-3/"/>
            </schema:type.listItem>
        </schema:type.breadcrumbList>
    </schema:type.itemPage>

Most of the time you don't have the according attributes available in the same Fluid template.
Imagine you want to set the breadcrumb in one template or partial and the website in another template
(e.g. in a news detail template). You can set the WebPage type and the breadcrumb independently:

    <schema:type.itemPage>
        <schema:type.organization -as="publisher" name="Acme Ltd."/>
    </schema:type.itemPage>

    <schema:type.breadcrumbList>
        <schema:type.listItem -as="itemListElement" name="Page 1" position="1">
            <schema:type.webPage -as="item" -id="https://example.org/page-1/"/>
        </schema:type.listItem>
        <schema:type.listItem -as="itemListElement" name="Page 2" position="2">
            <schema:type.collectionPage -as="item" -id="https://example.org/page-1/page-2/"/>
        </schema:type.listItem>
        <schema:type.listItem -as="itemListElement" name="Page 3" position="3">
            <schema:type.itemPage -as="item" -id="https://example.org/page-1/page-2/page-3/"/>
        </schema:type.listItem>
    </schema:type.breadcrumbList>

The extension is smart enough to combine them on request. The result is the same for both cases:

    {
        "@context": "http://schema.org",
        "@type": "ItemPage",
        "breadcrumb": {
            "@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "item": {
                        "@type":"WebPage",
                        "@id": "https://example.org/page-1/"
                    },
                    "name": "Page 1",
                    "position": "1"
                },
                {
                    "@type": "ListItem",
                    "item": {
                        "@type": "CollectionPage",
                        "@id": "https://example.org/page-1/page-2/"
                    },
                    "name": "Page 2",
                    "position": "2"
                },
                {
                    "@type": "ListItem",
                    "item": {
                        "@type": "ItemPage",
                        "@id": "https://example.org/page-1/page-2/page-3/"
                    },
                    "name": "Page 3",
                    "position": "3"
                }
            ]
        },
        "publisher": {
            "@type": "Organization",
            "name": "Acme Ltd."
        }
    } 

If you set the breadcrumb independently of the WebPage, this breadcrumb will be merged with a
breadcrumb defined in the WebPage type. Please keep in mind that according to the Google Structured
Data Testing Tool, only the type BreadcrumbList is allowed for the breadcrumb - either the schema.org
allows strings. Other types than the BreadcrumbList are ignored!

But you don't have to build the breadcrumb markup on your own. TYPO3 has a nice feature called MenuProcessor.

    page = PAGE
    page.10 = FLUIDTEMPLATE
    page.10 {
        dataProcessing {
            10 = TYPO3\CMS\Frontend\DataProcessing\MenuProcessor
            10 {
                special = rootline
                as = breadcrumb
            }
        }
    }

The output of this MenuProcessor can be now used in a Fluid template to populate the breadcrumb automatically
with the breadcrumb view helper:

    <schema:breadcrumb breadcrumb="{breadcrumb}"/>

As default the first item (mostly the home page) is stripped of, because it is not needed. But if you
care about it, you can render also the first item:

    <schema:breadcrumb breadcrumb="{breadcrumb}" renderFirstItem="1"/>

You can also build your own breadcrumb array to use in the view helper: It should have the following structure:

    $breadcrumb = [
        [
            'title' => 'Home page',
            'link' => '/',
            'data' => [
                'tx_schema_webpagetype' => 'WebPage',
            ],
        ],
        [
            'title' => 'Videos',
            'link' => '/videos/',
            'data' => [
                'tx_schema_webpagetype' => 'VideoGallery',
            ],
        ],
        [
            'title' => 'Unicorns in TYPO3 country',
            'link' => '/videos/unicorns-in-typo3-country/',
            'data' => [
                'tx_schema_webpagetype' => 'ItemPage',
            ],
        ],
    ];

```data.tx_schema_webpagetype``` can be omitted and defaults to WebPage.
