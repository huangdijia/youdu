<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Generators;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Huangdijia\Youdu\Config;
use Huangdijia\Youdu\Packer\MessagePacker;
use RuntimeException;

class AccessTokenGenerator
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var MessagePacker
     */
    protected $packer;

    public function __construct(Config $config, Client $client, MessagePacker $packer)
    {
        $this->config = $config;
        $this->client = $client;
        $this->packer = $packer;
    }

    /**
     * @throws RuntimeException
     * @throws GuzzleException
     * @return string
     */
    public function get()
    {
        $encrypted = $this->packer->pack((string) time());
        $parameters = [
            'buin' => $this->config->get('buin'),
            'appId' => $this->config->get('app_id'),
            'encrypt' => $encrypted,
        ];

        $url = '/cgi/gettoken';
        $response = $this->client->post($url, ['form_params' => $parameters]);
        $body = json_decode($response->getBody()->getContents(), true);

        if ($body['errcode'] != 0) {
            throw new RuntimeException($body['errmsg'], $body['errcode']);
        }

        $decrypted = $this->packer->unpack($body['encrypt']);
        $decoded = json_decode($decrypted, true);

        return $decoded['accessToken'];
    }
}
