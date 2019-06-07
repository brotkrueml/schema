<?php

namespace Brotkrueml\Schema\Generator\Model;

class Property
{
    /**
     * Id of the property, e.g. "http://schema.org/url"
     *
     * @var string
     */
    public $id = '';

    /**
     * Label of the property, e.g. "url"
     *
     * @var string
     */
    public $label = '';

    /**
     * Comment (or description) of the property, e.g. "URL of the item."
     *
     * @var string
     */
    public $comment = '';
}
