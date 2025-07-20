<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Injection;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Adminpanel\Utility\StateUtility;

/**
 * @internal
 */
final readonly class MarkupInjectionMiddleware implements MiddlewareInterface
{
    private const SCRIPT_TEMPLATE = '<script type="application/ld+json"%s>%s</script>';

    public function __construct(
        private MarkupProvider $markupProvider,
        private StreamFactoryInterface $streamFactory,
    ) {}

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler,
    ): ResponseInterface {
        $response = $handler->handle($request);

        $markup = $this->markupProvider->getMarkup($request);
        if ($markup !== '') {
            $response->getBody()->rewind();
            $contents = $response->getBody()->getContents();
            $contents = \str_ireplace(
                '</body>',
                \chr(10) . $this->renderMarkupWithScriptTag($markup) . \chr(10) . '</body>',
                $contents,
            );

            $response = $response->withBody($this->streamFactory->createStream($contents));
        }

        return $response;
    }

    private function renderMarkupWithScriptTag(string $markup): string
    {
        $idAttribute = '';
        if (\class_exists(StateUtility::class) && StateUtility::isActivatedForUser() && StateUtility::isOpen()) {
            // The id is necessary to select the JSON-LD for validation
            // @see Resources/Public/JavaScript/AdminPanel/Validate.js
            $idAttribute = ' id="ext-schema-jsonld"';
        }

        return \sprintf(
            self::SCRIPT_TEMPLATE,
            $idAttribute,
            $markup,
        );
    }
}
