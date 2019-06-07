<?php

namespace Brotkrueml\Schema\Generator\Model;

class Type
{
    /**
     * Id of the type, e.g. "http://schema.org/Thing"
     *
     * @var string
     */
    public $id = '';

    /**
     * Label of the type, e.g. "Thing"
     *
     * @var string
     */
    public $label = '';

    /**
     * Comment (or description) of the type, e.g. "The most generic type of item."
     *
     * @var string
     */
    public $comment = '';

    /**
     * Possible sub classes of the type, the values are the label.
     * There can be no, one or more than one sub class
     *
     * @var array
     */
    public $subClassOf = [];

    /**
     * Possible properties of the type
     *
     * @var Property[]
     */
    public $properties = [];
}
