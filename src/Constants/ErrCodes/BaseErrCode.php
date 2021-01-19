<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Constants;

use Huangdijia\Constants\AbstractConstants;

class BaseErrCode extends AbstractConstants
{
    /**
     * @Message("操作成功")
     */
    const ERRCODE_OK = 0;

    /**
     * @Message("未定义的系统错误")
     */
    const ERRCODE_INTERNALERR = -1;

    /**
     * @Message("查询结果逻辑假")
     */
    const ERRCODE_FALSE = 2;

    /**
     * @Message("接口权限不足")
     */
    const ERRCODE_NORIGHT = 3;

    /**
     * @Message("非法访问数据")
     */
    const ERRCODE_ILLEGAL_ACCESS = 4;

    /**
     * @Message("错误的请求")
     */
    const ERRCODE_INVALID_REQUEST = 5;
}