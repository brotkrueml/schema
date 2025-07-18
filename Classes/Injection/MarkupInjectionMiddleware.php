<?php

declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\Injection;

use Brotkrueml\Schema\Extension;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @internal
 */
final readonly class MarkupInjectionMiddleware implements MiddlewareInterface
{
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
            $markupWithScriptTag = \sprintf(
                Extension::JSONLD_TEMPLATE,
                $markup,
            );
            $response->getBody()->rewind();
            $contents = $response->getBody()->getContents();
            $contents = \str_ireplace(
                '</body>',
                \chr(10) . $markupWithScriptTag . \chr(10) . '</body>',
                $contents,
            );

            $response = $response->withBody($this->streamFactory->createStream($contents));
        }

        return $response;
    }
}
