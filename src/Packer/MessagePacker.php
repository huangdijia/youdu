<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Packer;

use Huangdijia\Youdu\Config;
use Huangdijia\Youdu\Constants\ErrCodes\GlobalErrCode;
use Huangdijia\Youdu\Encipher\Prpcrypt;
use RuntimeException;

class MessagePacker
{
    /**
     * @var Prpcrypt
     */
    protected $crypter;

    /**
     * @var Config
     */
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->crypter = $config->getCrypter();
    }

    /**
     * @throws RuntimeException
     * @return mixed
     */
    public function pack(string $message)
    {
        [$errcode, $encrypted] = $this->crypter->encrypt($message, $this->config->getAppId());

        if ($errcode != GlobalErrCode::OK) {
            throw new RuntimeException($encrypted, $errcode);
        }

        return $encrypted;
    }

    /**
     * @throws RuntimeException
     * @return string
     */
    public function unpack(string $message)
    {
        if (strlen($this->config->getAesKey()) != 44) {
            throw new RuntimeException('Illegal aesKey', GlobalErrCode::ILLEGAL_AES_KEY);
        }

        [$errcode, $decrypted] = $this->crypter->decrypt($message, $this->config->getAppId());

        if ($errcode != GlobalErrCode::OK) {
            throw new RuntimeException('Decrypt faild:' . $decrypted, $errcode);
        }

        return $decrypted;
    }
}
