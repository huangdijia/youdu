<?php
/**
 * This file is part of huangdijia/youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu;

use GuzzleHttp\Client;
use Huangdijia\Youdu\Encipher\Prpcrypt;
use Huangdijia\Youdu\Formatters\UrlFormatter;
use Huangdijia\Youdu\Generators\AccessTokenGenerator;
use Huangdijia\Youdu\Http\PendingRequest;
use Huangdijia\Youdu\Packer\MessagePacker;

class Config
{
    /**
     * @var AccessTokenGenerator
     */
    private $accessTokenGenerator;

    /**
     * @var array
     */
    private $config;

    /**
     * @var PendingRequest
     */
    private $client;

    /**
     * @var MessagePacker
     */
    private $packer;

    /**
     * @var Prpcrypt
     */
    private $crypter;

    /**
     * @var UrlFormatter
     */
    private $urlFormatter;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param null|mixed $default
     * @return mixed
     */
    public function get(string $key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->config;
        }

        return $this->config[$key] ?? $default;
    }

    /**
     * @return AccessTokenGenerator
     */
    public function getAccessTokenGenerator()
    {
        if (is_null($this->accessTokenGenerator)) {
            $this->accessTokenGenerator = new AccessTokenGenerator($this);
        }

        return $this->accessTokenGenerator;
    }

    /**
     * @return Prpcrypt
     */
    public function getCrypter()
    {
        if (is_null($this->crypter)) {
            $this->crypter = new Prpcrypt($this->getAesKey());
        }

        return $this->crypter;
    }

    /**
     * @return MessagePacker
     */
    public function getPacker()
    {
        if (is_null($this->packer)) {
            $this->packer = new MessagePacker($this);
        }

        return $this->packer;
    }

    /**
     * @return string
     */
    public function getApi()
    {
        return $this->get('api');
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->get('app_id');
    }

    /**
     * @return int
     */
    public function getBuin()
    {
        return $this->get('buin');
    }

    /**
     * @return string
     */
    public function getAesKey()
    {
        return $this->get('aes_key');
    }

    /**
     * @return PendingRequest
     */
    public function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new PendingRequest(function () {
                return new Client([
                    'base_uri' => $this->getApi(),
                    'timeout' => 5.0,
                ]);
            });
        }

        return $this->client;
    }

    /**
     * @return UrlFormatter
     */
    public function getUrlFormatter()
    {
        if (is_null($this->urlFormatter)) {
            $this->urlFormatter = new UrlFormatter($this);
        }

        return $this->urlFormatter;
    }
}
