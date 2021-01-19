<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Encipher;

use Huangdijia\Youdu\Exceptions\ErrCode;
use Throwable;

/**
 * Prpcrypt class.
 *
 * 提供接收和推送给公众平台消息的加解密接口.
 */
class Prpcrypt
{
    protected $key;

    protected $encoder;

    public function __construct($key = '')
    {
        $this->key = base64_decode($key);
        $this->encoder = new PKCS7Encoder();
    }

    /**
     * 对明文进行加密.
     *
     * @param string $text 需要加密的明文
     *
     * @return array
     */
    public function encrypt(string $text = '', string $appId = '')
    {
        try {
            //获得16位随机字符串，填充到明文之前
            $random = $this->getRandomStr();
            $text = $random . pack('N', strlen($text)) . $text . $appId;
            $iv = substr($this->key, 0, 16);
            $text = $this->encoder->encode($text);
            $encrypted = openssl_encrypt($text, 'AES-256-CBC', $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);

            // 使用BASE64对加密后的字符串进行编码
            return [ErrCode::ERRCODE_OK, base64_encode($encrypted)];
        } catch (Throwable $e) {
            return [ErrCode::$EncryptAESError, 'Encrypt AES Error:' . $e->getMessage()];
        }
    }

    /**
     * 对密文进行解密.
     *
     * @param string $encrypted 需要解密的密文
     * @param mixed $appId
     *
     * @return array
     */
    public function decrypt($encrypted, $appId)
    {
        try {
            // 使用BASE64对需要解密的字符串进行解码
            $encrypted = base64_decode($encrypted);
            $iv = substr($this->key, 0, 16);
            $decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', $this->key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
        } catch (Throwable $e) {
            return [ErrCode::$DecryptAESError, 'Decrypt AES Error:' . $e->getMessage()];
        }

        try {
            //去除补位字符
            $result = $this->encoder->decode($decrypted);

            //去除16位随机字符串,网络字节序和AppId
            if (strlen($result) < 16) {
                return '';
            }

            $content = substr($result, 16, strlen($result));
            $lenList = unpack('N', substr($content, 0, 4));
            $jsonLen = $lenList[1];
            $jsonContent = substr($content, 4, $jsonLen);
            $fromAppId = substr($content, $jsonLen + 4);
        } catch (Throwable $e) {
            return [ErrCode::$IllegalBuffer, 'Illegal Buffer'];
        }

        if ($fromAppId != 'sysOrgAssistant' && $fromAppId != $appId) {
            return [ErrCode::$ValidateAppIdError, 'Validate AppId Error:' . $e->getMessage()];
        }

        return [0, $jsonContent];
    }

    /**
     * 随机生成16位字符串.
     *
     * @return string
     */
    public function getRandomStr()
    {
        $str = '';
        $strPol = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < 16; ++$i) {
            $str .= $strPol[mt_rand(0, $max)];
        }

        return $str;
    }
}