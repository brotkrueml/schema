.. include:: /Includes.rst.txt

.. _sets-lists:

==============
Sets and lists
==============

Target group: **Integrators, Developers**

.. contents:: Table of Contents
   :local:


Introduction
============

Any property in Schema.org can have multiple values, which are provided in
JSON-LD as an array of values. These multiple values are technically treated as
an unordered set by default. But there are cases where the order of the values
matters, for example, steps in a recipe, or items in a list. Most parsers assume
source order, but it is not explicit.

.. seealso::
   -  `Supporting Ordering in schema.org`_
   -  `Multiple Values and Collections`_


.. _set:

Unordered set
=============

An unordered set of values can be achieved in the TYPO3 in the following ways.

Usage in PHP
------------

Use the :confval:`->addProperty($value) <abstracttype-addproperty>` method of the type to add multiple values
to a property:

.. literalinclude:: _Lists/_MyController1.php
   :language: php
   :caption: EXT:my_extension/Classes/Controller/MyController.php
   :emphasize-lines: 21-22

This results in the following output:

.. code-block:: json
   :emphasize-lines: 5-8

   {
     "@context": "https://schema.org/",
     "@type": "Person",
     "name": "John Smith",
     "sameAs": [
       "https://mastodon.example.com/@john-smith",
       "https://peertube.example.com/john-smith"
     ]
   }

The order of the values in the `sameAs` property does not matter in this
example.

Usage in Fluid
--------------

Use the :ref:`<schema:property> view helper <schema-property-view-helper>` to add multiple values to a
property:

.. code-block:: html
   :emphasize-lines: 2-3

   <schema:type.person name="John Smith">
      <schema:property -as="sameAs" value="https://mastodon.example.com/@john-smith"/>
      <schema:property -as="sameAs" value="https://peertube.example.com/john-smith"/>
   </schema:type.person>

This results in the following output:

.. code-block:: json
   :emphasize-lines: 5-8

   {
     "@context": "https://schema.org/",
     "@type": "Person",
     "name": "John Smith",
     "sameAs": [
       "https://mastodon.example.com/@john-smith",
       "https://peertube.example.com/john-smith"
     ]
   }

The order of the values in the `sameAs` property does not matter in this
example.


.. _list:

Ordered list
============

You can provide an ordered list as value for a property via the following API.

With `ItemList`
---------------

Usage in PHP
~~~~~~~~~~~~

.. literalinclude:: _Lists/_MyController2.php
   :language: php
   :caption: EXT:my_extension/Classes/Controller/MyController.php
   :emphasize-lines: 28-36

This results in the following output:

.. code-block:: json
   :emphasize-lines: 6-25

   {
     "@context": "https://schema.org",
     "@type": "Review",
     "name": "Megaphone 11 review",
     "positiveNotes": {
       "@type": "ItemList",
       "itemListElement": [
         {
           "@type": "ListItem",
           "name": "Tougher and water resistant design.",
           "position": "1"
         },
         {
           "@type": "ListItem",
           "name": "Cheery bright colours and solid feel.",
           "position": "2"
         },
         {
           "@type": "ListItem",
           "name": "Excellent amplification.",
           "position": "3"
         }
       ]
     }
   }

Usage in Fluid
~~~~~~~~~~~~~~

.. code-block:: html
   :emphasize-lines: 8-16

   <f:variable name="positiveNotes" value="{
      0: 'Tougher and water resistant design.',
      1: 'Cheery bright colours and solid feel.',
      2: 'Excellent amplification.',
   }"/>

   <schema:type.review name="Megaphone 11 review">
      <schema:type.itemList -as="positiveNotes">
         <f:for each="{positiveNotes}" as="note" iteration="i">
            <schema:type.listItem
               -as="itemListElement"
               position="{i.cycle}"
               name="{note}"
            />
         </f:for>
      </schema:type.itemList>
   </schema:type.review>

This results in the following output:

.. code-block:: json
   :emphasize-lines: 6-25

   {
     "@context": "https://schema.org",
     "@type": "Review",
     "name": "Megaphone 11 review",
     "positiveNotes": {
       "@type": "ItemList",
       "itemListElement": [
         {
           "@type": "ListItem",
           "name": "Tougher and water resistant design.",
           "position": "1"
         },
         {
           "@type": "ListItem",
           "name": "Cheery bright colours and solid feel.",
           "position": "2"
         },
         {
           "@type": "ListItem",
           "name": "Excellent amplification.",
           "position": "3"
         }
       ]
     }
   }

With `@list`
------------

.. versionadded:: 4.4.0

A property providing an ordered list of values via `@list` is displayed in the
admin panel via the `LIST` annotation:

.. figure:: /Images/Developer/AdminPanelOrderedList.png
   :alt: Ordered list in the admin panel

   Ordered list in the admin panel

Usage in PHP
-------------

Use the :php-short:`\Brotkrueml\Schema\Core\Model\OrderedList` class and pass the
items on instantiation:

.. literalinclude:: _Lists/_MyController3.php
   :language: php
   :caption: EXT:my_extension/Classes/Controller/MyController.php
   :emphasize-lines: 28

This results in the following output:

.. code-block:: json
   :emphasize-lines: 6-10

   {
     "@context": "https://schema.org",
     "@type": "Review",
     "name": "Megaphone 11 review",
     "positiveNotes": {
       "@list": [
         "Tougher and water resistant design.",
         "Cheery bright colours and solid feel.",
         "Excellent amplification."
       ]
     }
   }

If you need to pass a type as list value, create the type and assign an `@id`
to it, then pass the `@id` as value (for example, via the
:ref:`blank node identifier <blank-node-identifier>`):

.. literalinclude:: _Lists/_MyController4.php
   :language: php
   :caption: EXT:my_extension/Classes/Controller/MyController.php
   :emphasize-lines: 34,36,41

This results in the following output:

.. code-block:: json
   :emphasize-lines: 6,11,16,23-33

   {
     "@context": "https://schema.org/",
     "@graph": [
       {
         "@type": "ListItem",
         "@id": "_:b0",
         "name": "Tougher and water resistant design."
       },
       {
         "@type": "ListItem",
         "@id": "_:b1",
         "name": "Cheery bright colours and solid feel."
       },
       {
         "@type": "ListItem",
         "@id": "_:b2",
         "name": "Excellent amplification."
       },
       {
         "@type": "Review",
         "name": "Megaphone 11 review",
         "positiveNotes": {
           "@list": [
             {
               "@id": "_:b0"
             },
             {
               "@id": "_:b1"
             },
             {
               "@id": "_:b2"
             }
           ]
         }
       }
     ]
   }

Usage in Fluid
~~~~~~~~~~~~~~

Use the :ref:`<schema:orderedList> view helper <schema-orderedlist-view-helper>`:

.. code-block:: html
   :emphasize-lines: 8

   <f:variable name="positiveNotes" value="{
      0: 'Tougher and water resistant design.',
      1: 'Cheery bright colours and solid feel.',
      2: 'Excellent amplification.',
   }"/>

   <schema:type.review name="Megaphone 11 review">
      <schema:orderedList -as="positiveNotes" items="{positiveNotes}"/>
   </schema:type.review>

This results in the following output:

.. code-block:: json
   :emphasize-lines: 6-10

   {
     "@context": "https://schema.org",
     "@type": "Review",
     "name": "Megaphone 11 review",
     "positiveNotes": {
       "@list": [
         "Tougher and water resistant design.",
         "Cheery bright colours and solid feel.",
         "Excellent amplification."
       ]
     }
   }

If you need to pass a type as list value, create the type and assign an `@id`
to it, then pass the `@id` as value (for example, via the
:ref:`blank node identifier <blank-node-identifier>`):

.. code-block:: html
   :emphasize-lines: 7-12,15

   <f:variable name="positiveNotes" value="{
      0: 'Tougher and water resistant design.',
      1: 'Cheery bright colours and solid feel.',
      2: 'Excellent amplification.',
   }"/>

   <f:variable name="orderedList" value="{null}"/>
   <f:for each="{positiveNotes}" as="note" reverse="1">
     <f:variable name="id"><schema:blankNodeIdentifier/></f:variable>
     <f:variable name="orderedList"><f:merge array="{0: '{id}'}" with="{orderedList}"/></f:variable>
     <schema:type.listItem -id="{id}" name="{note}"/>
   </f:for>

   <schema:type.review name="Megaphone 11 review">
      <schema:orderedList -as="positiveNotes" items="{orderedList}"/>
   </schema:type.review>

.. note::
   the :html:`reverse="1"` attribute is necessary in this case, as
   :html:`<f:merge>` adds the new item to the beginning of the array.

This results in the following output:

.. code-block:: json
   :emphasize-lines: 6,11,16,23-33

   {
     "@context": "https://schema.org/",
     "@graph": [
       {
         "@type": "ListItem",
         "@id": "_:b0",
         "name": "Excellent amplification."
       },
       {
         "@type": "ListItem",
         "@id": "_:b1",
         "name": "Cheery bright colours and solid feel."
       },
       {
         "@type": "ListItem",
         "@id": "_:b2",
         "name": "Tougher and water resistant design."
       },
       {
         "@type": "Review",
         "name": "Megaphone 11 review",
         "positiveNotes": {
           "@list": [
             {
               "@id": "_:b2"
             },
             {
               "@id": "_:b1"
             },
             {
               "@id": "_:b0"
             }
           ]
         }
       }
     ]
   }

.. _Supporting Ordering in schema.org: https://blog.schema.org/2026/06/17/supporting-ordering-in-schema-org/
.. _Multiple Values and Collections: https://schema.org/docs/datamodel.html#multiple-values
