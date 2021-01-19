<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu;

use GuzzleHttp\Client;
use Huangdijia\Youdu\Exceptions\ErrCode;
use Huangdijia\Youdu\Formatters\UrlFormatter;
use Huangdijia\Youdu\Http\Response;
use Huangdijia\Youdu\Packer\MessagePacker;
use RuntimeException;

class App
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
     * @var UrlFormatter
     */
    protected $urlFormatter;

    /**
     * @var MessagePacker
     */
    protected $packer;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->client = $config->getClient();
        $this->packer = $config->getPacker();
        $this->urlFormatter = $config->getUrlFormatter();
    }

    public function send($message)
    {
        $encrypted = $this->packer->pack($message->toJson());
        $parameters = [
            'buin' => $this->buin,
            'appId' => $this->appId,
            'encrypt' => $encrypted,
        ];

        $url = $this->urlFormatter->format('/cgi/msg/send');
        $response = new Response($this->client->post($url, ['form_params' => $parameters]));

        if ($response->status() != 200) {
            throw new RuntimeException('http request code ' . $response['httpCode'], ErrCode::$IllegalHttpReq);
        }

        $body = json_decode($response['body'], true);

        if ($body['errcode'] !== 0) {
            throw new RuntimeException($body['errmsg'], $body['errcode']);
        }

        return true;
    }
}
