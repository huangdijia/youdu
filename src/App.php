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
use GuzzleHttp\Exception\GuzzleException;
use Huangdijia\Youdu\Constants\BaseErrCode;
use Huangdijia\Youdu\Formatters\UrlFormatter;
use Huangdijia\Youdu\Http\Response;
use Huangdijia\Youdu\Messages\App\Message;
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

    /**
     * @throws RuntimeException
     * @throws GuzzleException
     * @return true
     */
    public function send(Message $message)
    {
        $encrypted = $this->packer->pack($message->toJson());
        $parameters = [
            'buin' => $this->config->getBuid(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $encrypted,
        ];

        $url = $this->urlFormatter->format('/cgi/msg/send');
        $response = new Response($this->client->post($url, ['form_params' => $parameters]));

        if ($response->status() != 200) {
            throw new RuntimeException('http request code ' . $response->status(), BaseErrCode::ERRCODE_INVALID_REQUEST);
        }

        if ($response['errcode'] !== 0) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        return true;
    }
}
