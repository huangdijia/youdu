<?php
/**
 * This file is part of huangdijia/youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Constants\ErrCodes;

use Huangdijia\Constants\AbstractConstants;

class GlobalErrCode extends AbstractConstants
{
    /**
     * @Message("OK")
     */
    const OK = 0;

    /**
     * @Message("驗證簽名錯誤")
     */
    const VALIDATE_SIGNATURE_ERROR = -40001;

    /**
     * @Message("簽名錯誤")
     */
    const COMPUTE_SIGNATURE_ERROR = -40002;

    /**
     * @Message("非法 AES KEY")
     */
    const ILLEGAL_AES_KEY = -40003;

    /**
     * @Message("APP_ID 錯誤")
     */
    const VALIDATE_APPID_ERROR = -40004;

    /**
     * @Message("AES 加密錯誤")
     */
    const ENCRYPT_AES_ERROR = -40005;

    /**
     * @Message("AES 解密錯誤")
     */
    const DECRYPT_AES_ERROR = -40006;

    /**
     * @Message("BUFF 錯誤")
     */
    const ILLEGAL_BUFFER = -40007;

    /**
     * @Message("HTTP 請求錯誤")
     */
    const ILLEGAL_HTTP_REQ = -40008;
}
