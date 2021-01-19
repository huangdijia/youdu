<?php
/**
 * This file is part of huangdijia/youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Http;

use Huangdijia\Youdu\Exceptions\ClientException;
use Huangdijia\Youdu\Exceptions\ServerException;
use LogicException;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class Response implements \ArrayAccess
{
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var null|array
     */
    private $decoded;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function __call($name, $arguments)
    {
        return $this->response->{$name}(...$arguments);
    }

    /**
     * Get the body of the response.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->body();
    }

    /**
     * Body.
     * @throws RuntimeException
     * @return string
     */
    public function body()
    {
        return $this->response->getBody()->getContents();
    }

    /**
     * Headers.
     * @return array
     */
    public function headers()
    {
        $headers = [];

        foreach ($this->response->getHeaders as $name => $values) {
            $headers[$name] = implode(', ', $values);
        }

        return $headers;
    }

    /**
     * Get a header from the response.
     *
     * @return string
     */
    public function header(string $header)
    {
        return $this->response->getHeaderLine($header);
    }

    /**
     * Make new instance.
     * @return Response
     */
    public static function make(ResponseInterface $response)
    {
        return new self($response);
    }

    /**
     * Status.
     * @return int
     */
    public function status()
    {
        return $this->response->getStatusCode();
    }

    /**
     * Json.
     * @param null|mixed $default
     * @throws RuntimeException
     * @return mixed
     */
    public function json(string $key = null, $default = null)
    {
        if (is_null($this->decoded)) {
            $this->decoded = json_decode($this->body(), true);
        }

        if (is_null($key)) {
            return $this->decoded;
        }

        return array_get($this->decoded, $key, $default);
    }

    /**
     * Get the JSON decoded body of the response as an object.
     *
     * @return object
     */
    public function object()
    {
        return json_decode($this->body(), false);
    }

    /**
     * Content encoded as XML.
     *
     * @return SimpleXMLElement
     */
    public function xml()
    {
        return new \SimpleXMLElement($this->body());
    }

    /**
     * Determine if the request was successful.
     *
     * @return bool
     */
    public function successful()
    {
        return $this->status() >= 200 && $this->status() < 300;
    }

    /**
     * Determine if the response code was "OK".
     *
     * @return bool
     */
    public function ok()
    {
        return $this->status() === 200;
    }

    /**
     * Determine if the response indicates a client or server error occurred.
     *
     * @return bool
     */
    public function failed()
    {
        return $this->serverError() || $this->clientError();
    }

    /**
     * Determine if the response indicates a client error occurred.
     *
     * @return bool
     */
    public function clientError()
    {
        return $this->status() >= 400 && $this->status() < 500;
    }

    /**
     * Determine if the response indicates a server error occurred.
     *
     * @return bool
     */
    public function serverError()
    {
        return $this->status() >= 500;
    }

    /**
     * Throw an exception if a server or client error occurred.
     * @throws Exception
     * @return $this
     */
    public function throw()
    {
        if ($this->failed()) {
            if ($this->clientError()) {
                throw new ClientException($this->body());
            }

            if ($this->serverError()) {
                throw new ServerException($this->body());
            }

            throw new \Exception($this->body());
        }

        return $this;
    }

    /**
     * Determine if the given offset exists.
     *
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->json()[$offset]);
    }

    /**
     * Get the value for a given offset.
     *
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->json()[$offset];
    }

    /**
     * Set the value at the given offset.
     *
     * @param string $offset
     * @param mixed $value
     *
     * @throws \LogicException
     */
    public function offsetSet($offset, $value)
    {
        throw new LogicException('Response data may not be mutated using array access.');
    }

    /**
     * Unset the value at the given offset.
     *
     * @param string $offset
     *
     * @throws \LogicException
     */
    public function offsetUnset($offset)
    {
        throw new LogicException('Response data may not be mutated using array access.');
    }

    /**
     * Get the underlying PSR response for the response.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function toPsrResponse()
    {
        return $this->response;
    }
}
