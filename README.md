# HttpClient Middleware for PSR-7

Missing interfaces for HTTP-Client middlewares using PSR-7 messages.

The goal is to provide interfaces that you can depend on in your applications
and non-http libraries. This way we can implement independent code and everyone
can use whatever HTTP client he wants.

There are three abstractions/levels of implementation possible. Every one of
them is optional!

## A Simple Http Client

Very simple http client interface that avoids factories by specifing all
request variables directly. It intentionally gets some of the data from an
untyped array for simplicity.

```php
<?php

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
    public function request($method, $uri, array $options = []);
}
```

Usage:

```php
<?php

$client = createMySimpleClient();
$response = $client->request('GET', 'http://php.net');
```

## Http Client Interface

A more flexible HTTP client allows access to the Request object
and provides a factory to create Request and Uri objects to
hide the underyling implementation.

```php
<?php
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

interface RequestFactoryInterface
{
    /**
     * @return \Psr\Http\Message\RequestInterface
     */
    public function createRequest();

    /**
     * @param string $uri - If uri is provided the result of parse_url() is set as parts for UriInterface
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
```

Usage:

```php
<?php

$client = createMyHttpClient();
$factory = createMyClientFactory();
$request = $factory->createRequest();
    ->withMethod('GET')
    ->withUri($factory->createUri("http://php.net"))
    ->withHeader("X-Foo", "Bar");

$response = $client->send($request);
```

## Asynchronous Http-Client

Optional interface when you want your client to be async. Uses promises
response that looks exactly the same as [React
Promises](https://github.com/reactphp/promise) to avoid having to build a new
one.

This interface requires PHP 5.4 because of the callable typehint.

```php
<?php
interface AsyncClientInterface
{
    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array $options - Vendor-specific options, don't rely on for interop.

     * @return PromiseInterface
     */
    public function sendAsync(RequestInterface $request, array $options = []);

    /**
     * @param string $method
     * @param string|UriInterface $uri
     * @param array $options - Vendor-specific options, don't rely on for interop.
     *
     * @return PromiseInterface
     */
    public function requestAsync($method, $uri, array $options = []);
}

/**
 * API Compatible to React\PromiseInterface to allow usage.
 */
interface PromiseInterface
{
    /**
     * @return PromiseInterface
     */
    public function then(callable $onFulfilled = null, callable $onRejected = null, callable $onProgress = null);
}
```
