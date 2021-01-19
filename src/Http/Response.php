<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Http;

use Huangdijia\Youdu\Exceptions\ClientException;
use Huangdijia\Youdu\Exceptions\ServerException;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class Response
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
     * Status.
     * @return int
     */
    public function status()
    {
        return $this->response->getStatusCode();
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
            throw_if($this->clientError(), new ClientException($this->body()));

            throw_if($this->serverError(), new ServerException($this->body()));

            throw new \Exception($this->body());
        }

        return $this;
    }
}
