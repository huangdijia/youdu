<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Constants\ErrCodes;

use Huangdijia\Constants\AbstractConstants;

class GroupErrCode extends AbstractConstants
{
    /**
     * @Message("群名称为空")
     */
    const ERRCODE_MISS_GROUPNAME = 500001;

    /**
     * @Message("群名称格式不正确(string)")
     */
    const ERRCODE_INVALID_FORMAT_GROUPNAME = 500002;

    /**
     * @Message("群名称长度超过限制")
     */
    const ERRCODE_OVERLIMIT_GROUPNAME = 500003;

    /**
     * @Message("不存在该群")
     */
    const ERRCODE_GROUP_NOTEXIST = 500004;

    /**
     * @Message("非法访问群")
     */
    const ERRCODE_GROUP_ACCESS_ERROR = 500005;

    /**
     * @Message("缺少群ID")
     */
    const ERRCODE_MISS_GROUPID = 500006;

    /**
     * @Message("无效的userId")
     */
    const ERRCODE_INVALID_GROUP_USERID = 500007;

    /**
     * @Message("无效的群Id")
     */
    const ERRCODE_INVALID_FORMAT_GROUPID = 500008;
}
