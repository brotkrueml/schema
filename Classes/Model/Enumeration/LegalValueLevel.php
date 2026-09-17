<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Model\Enumeration;

use Brotkrueml\Schema\Core\Model\EnumerationInterface;

/**
 * A list of possible levels for the legal validity of a legislation.
 * @experimental This enum is considered experimental and may change at any time until it is declared stable.
 */
enum LegalValueLevel implements EnumerationInterface
{
    /**
     * Indicates that the publisher gives some special status to the publication of the document. ("The Queens Printer" version of a UK Act of Parliament, or the PDF version of a Directive published by the EU Office of Publications). Something "Authoritative" is considered to be also OfficialLegalValue".
     */
    case AuthoritativeLegalValue;

    /**
     * Indicates a document for which the text is conclusively what the law says and is legally binding. (e.g. The digitally signed version of an Official Journal.)
     * Something "Definitive" is considered to be also AuthoritativeLegalValue.
     */
    case DefinitiveLegalValue;

    /**
     * All the documents published by an official publisher should have at least the legal value level "OfficialLegalValue". This indicates that the document was published by an organisation with the public task of making it available (e.g. a consolidated version of a EU directive published by the EU Office of Publications).
     */
    case OfficialLegalValue;

    /**
     * Indicates that a document has no particular or special standing (e.g. a republication of a law by a private publisher).
     */
    case UnofficialLegalValue;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
