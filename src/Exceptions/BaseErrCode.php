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

class BaseErrCode
{
    const ERRCODE_OK = 0; // 操作成功,查询结果逻辑真

    const ERRCODE_INTERNALERR = -1; // 异常,未定义的系统错误

    const ERRCODE_FALSE = 2; // 查询结果逻辑假

    const ERRCODE_NORIGHT = 3; // 接口权限不足

    const ERRCODE_ILLEGAL_ACCESS = 4; // 非法访问数据

    const ERRCODE_INVALID_REQUEST = 5; // 错误的请求
}
