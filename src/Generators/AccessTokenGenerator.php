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
use Huangdijia\Youdu\Http\Response;
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

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->client = $config->getClient();
        $this->packer = $config->getPacker();
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
            'buin' => $this->config->getBuin(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $encrypted,
        ];

        $url = '/cgi/gettoken';
        $response = new Response($this->client->post($url, ['form_params' => $parameters]));

        if ($response['errcode'] != 0) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        $decrypted = $this->packer->unpack($response['encrypt']);
        $decoded = json_decode($decrypted, true);

        return $decoded['accessToken'];
    }
}
