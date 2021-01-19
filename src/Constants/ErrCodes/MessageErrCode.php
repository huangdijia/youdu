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

class MessageErrCode extends AbstractConstants
{
    /**
     * @Message("toUser超过长度")
     */
    const ERRCODE_TOUSER_OVERLIMIT = 200001;

    /**
     * @Message("无效的toUser")
     */
    const ERRCODE_INVALID_TOUSER = 200007;

    /**
     * @Message("上传文件格式失败")
     */
    const ERRCODE_INVALID_MULTIPART = 200008;

    /**
     * @Message("无效的文件类型")
     */
    const ERRCODE_INVALID_FILETYPE = 200009;

    /**
     * @Message("资源文件不存在")
     */
    const ERRCODE_FILE_NOTEXIST = 200010;
}
