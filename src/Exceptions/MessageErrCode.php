<?php

declare(strict_types=1);
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 */
namespace Huangdijia\Youdu\Exceptions;

class MessageErrCode
{
    const ERRCODE_TOUSER_OVERLIMIT = 200001; // toUser超过长度

    const ERRCODE_INVALID_TOUSER = 200007; // 无效的toUser

    const ERRCODE_INVALID_MULTIPART = 200008; // 上传文件格式失败

    const ERRCODE_INVALID_FILETYPE = 200009; // 无效的文件类型

    const ERRCODE_FILE_NOTEXIST = 200010; // 资源文件不存在
}
