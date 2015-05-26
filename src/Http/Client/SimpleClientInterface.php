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

interface SimpleClientInterface
{
    /**
     * @param string $method
     * @param string|UriInterface $uri
     * @param array $options - Vendor-specific options, don't rely on for interop.
     *
     * Standard compliant client must implement the following options:
     *
     * - "headers" is a list of headers, for example ["Content-Type: application/json"]
     * - "body" contains the HTTP body if sending POST, PUT, ...
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function request($method, $uri, array $options = array());
}
