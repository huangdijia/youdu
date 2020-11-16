<?php

namespace Huangdijia\Youdu\Encipher;

use Huangdijia\Youdu\Exceptions\ErrCode;
use Throwable;

class SHA1
{
    /**
     * 用SHA1算法生成安全签名
     * @param string $token 票据
     * @param string $timestamp 时间戳
     * @param string $nonce 随机字符串
     * @param string $encrypt 密文消息
     */
    public function getSHA1($token, $timestamp, $nonce, $encrypt_msg)
    {
        //排序
        try {
            $array = [$encrypt_msg, $token, $timestamp, $nonce];
            sort($array, SORT_STRING);
            $str = implode($array);

            return [ErrCode::$OK, sha1($str)];
        } catch (Throwable $e) {
            return [ErrCode::$ComputeSignatureError, $e->getMessage()];
        }
    }

}
