<?php
/**
 * Http Client Middleware
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace Http\Client;

interface RequestFactoryInterface
{
    /**
     * @return \Psr\Http\Message\RequestInterface
     */
    public function createRequest();

    /**
     * @param string $uri - If uri is provided the result of parse_url() is set as parts for UriInterface
     * @throws \InvalidArgumentException When passed $uri is not a string or not parsable uri.
     * @return \Psr\Http\Message\UriInterface
     */
    public function createUri($uri = null);

    /**
     * @param mixed $data
     * @throws \InvalidArgumentException When passed data cannot be converted to a stream.
     * @return \Psr\Http\Message\StreamInterface
     */
    public function createStream($data);
}
