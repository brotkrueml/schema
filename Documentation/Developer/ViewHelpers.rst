.. include:: ../Includes.txt


.. _view-helpers:

======================
Using the View Helpers
======================

Target group: **Developers**

With the help of ``<schema:type>`` view helpers you can define schema markup in Fluid templates. This can be helpful
if you can't use the :ref:`API <api>`, e.g. in third-party extensions.

Each type in the schema.org vocabulary is mapped into an according view helper. The properties of a type are available
as view helper arguments. As you will see in the example, you can also nest view helpers into each other.

There are currently over 600 view helpers available.


Starting with an Example
========================

Let's start with a simple example. It's the same markup about John Smith as in the API reference, so you can compare
the differences.

Imagine you describe a `person <https://schema.org/Person>`__ on a plugin's detail page that you want to enrich with
structured markup:

.. code-block:: html

   <schema:type.person
      -id="http://example.org/#person-42"
      givenName="John"
      familyName="Smith"
      gender="http://schema.org/Male"
   >
      <schema:type.corporation
         -as="worksFor"
         name="Acme Ltd."
         image="https://example.org/logo.png"
         url="https://example.org/">
            <schema:property -as="sameAs" value="https://twitter.com/acme"/>
            <schema:property -as="sameAs" value="https://facebook.com/acme"/>
      </schema:type.corporation>
   </schema:type.person>

Every type view helper starts with ``<schema:type.xxx>`` where ``xxx`` ist the lower camel case variant of the schema.org
type name.

The according properties (like ``givenName`` and ``familyName``) are attributes. You can find a list of all available
properties for a specific type on the schema.org page, e.g. for the `Person <http://schema.org/Person>`__.

In the example, there are two attributes that begin with a -. They are a explained in detail in the chapter
:ref:`Special Attributes <view-helpers-special-attributes>`.

Please also recognise the <schema:property> view helper. With this view helper you can pass more than one string value
to the according type.


.. _view-helpers-special-attributes:

Special Attributes
------------------

The special attributes are starting with a dash (-) to separate them from the common properties of the schema.org
specification and to avoid collisions. Let's have a deeper look on them.


.. _view-helpers-id:

-id
~~~

This attribute sets a unique id for the type and is mapped in JSON-LD to the ``@id`` property. The LD in JSON-LD means
"linked data". With an ``@id`` you can define a type on one page (e.g. ``Corporation``):

.. code-block:: json
   :emphasize-lines: 4

   {
      "@context": "http://schema.org",
      "@type": "Corporation",
      "@id": "http://example.org/#organization-1",
      "name": "Acme Ltd.",
      "image": "https://example.org/logo.png",
      "url": "https://example.org",
      "sameAs": ["https://twitter.com/acme", "https://facebook.com/acme"]
   }

and reference it on the same or another page (e.g. ``Person``):

.. code-block:: json
   :emphasize-lines: 10

   {
      "@context": "http://schema.org",
      "@type": "Person",
      "@id": "http://example.org/#person-42",
      "givenName": "John",
      "familyName": "Smith",
      "gender": "http://schema.org/Male",
      "worksFor": {
         "@type": "Corporation",
         "@id": "http://example.org/#organization-1",
         "name": "Acme Ltd."
      }
   }

.. tip::

   You can also cross-reference the types between different websites. The @id is globally unique, so a best practise is to
   use an IRI for it. It is also good practise to add the name to it.


.. _view-helpers-as:

-as
~~~

This attribute is used to connect a type to its parent. In the above example, you can see that the corporation type view
helper uses -as to connect to the ``worksFor`` property of the person type view helper.

.. note::

   The usage of the attribute makes only sense in a child. If it is used in a parent type the view helper is ignored.


.. _view-helpers-specific-type:

-specificType
~~~~~~~~~~~~~

Sometimes it can may be helpful to set a specific type. Imagine you have records of places in the backend where you
can select which type of specific place a record has: e.g. ``Museum``, ``Airport``, ``Park`` or ``Zoo``. In a Fluid
template you can loop over these records when they are on the same page. But it is not very convenient to use a switch
or if view helper to choose the correct type. For this scenario you can benefit from this argument:

.. code-block:: html
   :emphasize-lines: 4

   <f:for each="{places}" as="place">
      <schema:type.place
         name="{place.name}"
         -specificType="{place.type}"
      />
   </f:for>

.. important::

   When using the ``-specificType`` attribute you can only set the properties of the original type view helper, no
   additional ones from the specific type.


-isMainEntityOfWebPage
~~~~~~~~~~~~~~~~~~~~~~

This argument defines the type as the :ref:`main entity <main-entity-of-web-page>` of a :ref:`web page <web-page-type>`:

.. code-block:: html
   :emphasize-lines: 3

   <schema:type.person
      -id="http://example.org/#person-42"
      -isMainEntityOfWebPage="1"
      givenName="John"
      familyName="Smith"
      gender="http://schema.org/Male"
   />

which results in the output:

.. code-block:: json
   :emphasize-lines: 3-4,9

   {
      "@context": "http://schema.org",
      "@type": "WebPage",
      "mainEntity": {
         "@type": "Person",
         "@id": "http://example.org/#person-42",
         "givenName": "John",
         "familyName": "Smith",
         "gender": "http://schema.org/Male"
      }
   }


Property View Helper
====================

You can only set a string value in the argument of a type view helper, but sometimes it is necessary to add more than
one value to it. There comes the property view helper into the game:

.. code-block:: html
   :emphasize-lines: 5-6

   <schema:type.corporation
      name="Acme Ltd."
      image="https://example.org/logo.png"
      url="https://example.org/">
         <schema:property -as="sameAs" value="https://twitter.com/acme"/>
         <schema:property -as="sameAs" value="https://facebook.com/acme"/>
   </schema:type.corporation>

You can use as much property view helpers as you like for the same property. If you prefer, you can combine the view
helpers as follows:

.. code-block:: html

   <schema:type.corporation>
      <schema:property -as="name" value="Acme Ltd."/>
      <schema:property -as="image" value="https://example.org/logo.png"/>
      <schema:property -as="url" value="https://example.org/"/>
      <schema:property -as="sameAs" value="https://twitter.com/acme"/>
      <schema:property -as="sameAs" value="https://facebook.com/acme"/>
   </schema:type.corporation>


The ``<schema:property>`` view helper accepts two argument, both are required.


-as
---

You know already the ``-as`` attribute from the type view helpers. Its purpose is the same, it references the property
in the parent ``<schema:type>`` view helper.


value
-----

The ``value`` argument sets the value of the property, as you guessed already.


Breadcrumb View Helper
======================

This view helper is described in-depth in the chapter :ref:`The Breadcrumb Markup <breadcrumb-view-helper>`.


Using the XML Schema (XSD) in your Template
===========================================

It is possible to assist your code editor on suggesting the tag name and the possible attributes:

.. figure:: ../Images/Developer/XsdSchemaSuggestion.png
   :alt: Auto completion in PhpStorm with configured XSD schema

   Auto completion in PhpStorm with configured XSD schema

Just add the ``schema`` namespace to the root element of your Fluid template:

.. code-block:: html
   :emphasize-lines: 3-4

   <html
       xmlns:f="https://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
       xmlns:schema="http://typo3.org/ns/Brotkrueml/Schema/ViewHelpers"
       schema:schemaLocation="https://brot.krue.ml/schemas/schema-1.0.0.xsd"
       data-namespace-typo3-fluid="true"
   >

The relevant parts are the namespace declaration (``xmlns:schema="http://typo3.org/ns/Brotkrueml/Schema/ViewHelpers"``)
and the ``schema:schemaLocation`` attribute which points to the recent XSD definition.

You can also import the XSD file into your favorite IDE after downloading it from the following URL:
`https://brot.krue.ml/schemas/schema-1.0.0.xsd <https://brot.krue.ml/schemas/schema-1.0.0.xsd>`__.
