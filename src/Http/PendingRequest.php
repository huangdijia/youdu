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

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\UriInterface;

class PendingRequest
{
    /**
     * @var Closure
     */
    private $clientClosure;

    public function __construct(Closure $clientClosure)
    {
        $this->clientClosure = $clientClosure;
    }

    /**
     * @return Client
     */
    public function buildClient()
    {
        return call_user_func_array($this->clientClosure, []);
    }

    /**
     * @param string|UriInterface $url
     * @throws GuzzleException
     * @return Response
     */
    public function send(string $method = 'get', $url = '', array $options = [])
    {
        return new Response($this->buildClient()->request($method, $url, $options));
    }

    /**
     * @param string|UriInterface $url
     * @param null|array $query
     * @throws GuzzleException
     * @return Response
     */
    public function get($url, $query = null)
    {
        return $this->send('GET', $url, ['query' => $query]);
    }

    /**
     * @param string|UriInterface $url
     * @param string $bodyFormat form_params/multipart/json
     * @throws GuzzleException
     * @return Response
     */
    public function post($url, array $data = [], string $bodyFormat = 'json')
    {
        return $this->send('POST', $url, [$bodyFormat => $data]);
    }
}
