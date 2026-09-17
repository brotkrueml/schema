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
 * <a href="https://www.iptc.org/">IPTC</a> "Digital Source" codes for use with the digitalSourceType property, providing information about the source for a digital media object.
 * In general these codes are not declared here to be mutually exclusive, although some combinations would be contradictory if applied simultaneously, or might be considered mutually incompatible by upstream maintainers of the definitions. See the IPTC <a href="https://www.iptc.org/std/photometadata/documentation/userguide/">documentation</a>
 * for <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">detailed definitions</a> of all terms.
 */
enum IPTCDigitalSourceEnumeration implements EnumerationInterface
{
    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/algorithmicMedia">algorithmic media</a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case AlgorithmicMediaDigitalSource;

    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/algorithmicallyEnhanced">algorithmically enhanced</a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case AlgorithmicallyEnhancedDigitalSource;

    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/compositeCapture">composite capture</a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case CompositeCaptureDigitalSource;

    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/algorithmicMedia">algorithmic media</a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case CompositeDigitalSource;

    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/compositeSynthetic">composite synthetic</a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case CompositeSyntheticDigitalSource;

    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/compositeWithTrainedAlgorithmicMedia">composite with trained algorithmic media</a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case CompositeWithTrainedAlgorithmicMediaDigitalSource;

    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/dataDrivenMedia">data driven media</a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case DataDrivenMediaDigitalSource;

    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/digitalArt">digital art</a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case DigitalArtDigitalSource;

    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/digitalCapture">digital capture</a></a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case DigitalCaptureDigitalSource;

    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/minorHumanEdits">minor human edits</a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case MinorHumanEditsDigitalSource;

    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/algorithmicMedia">algorithmic media</a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case MultiFrameComputationalCaptureDigitalSource;

    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/negativeFilm">negative film</a></a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case NegativeFilmDigitalSource;

    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/positiveFilm">positive film</a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case PositiveFilmDigitalSource;

    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/print">print</a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case PrintDigitalSource;

    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/algorithmicMedia">algorithmic media</a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case ScreenCaptureDigitalSource;

    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/trainedAlgorithmicMedia">trained algorithmic media</a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case TrainedAlgorithmicMediaDigitalSource;

    /**
     * Content coded as '<a href="https://cv.iptc.org/newscodes/digitalsourcetype/virtualRecording">virtual recording</a>' using the IPTC <a href="https://cv.iptc.org/newscodes/digitalsourcetype/">digital source type</a> vocabulary.
     */
    case VirtualRecordingDigitalSource;

    public function canonical(): string
    {
        return 'https://schema.org/' . $this->name;
    }
}
