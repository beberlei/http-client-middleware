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

use Psr\Http\Message\RequestInterface;

interface ClientInterface
{
    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array $options - Vendor-specific options, don't rely on for interop.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(RequestInterface $request, array $options = []);
}
