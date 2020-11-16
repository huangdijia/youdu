<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Exceptions;

class GroupErrCode
{
    const ERRCODE_MISS_GROUPNAME = 500001; // 群名称为空

    const ERRCODE_INVALID_FORMAT_GROUPNAME = 500002; // 群名称格式不正确(string)

    const ERRCODE_OVERLIMIT_GROUPNAME = 500003; // 群名称长度超过限制

    const ERRCODE_GROUP_NOTEXIST = 500004; // 不存在该群

    const ERRCODE_GROUP_ACCESS_ERROR = 500005; // 非法访问群

    const ERRCODE_MISS_GROUPID = 500006; // 缺少群ID

    const ERRCODE_INVALID_GROUP_USERID = 500007; // 无效的userId

    const ERRCODE_INVALID_FORMAT_GROUPID = 500008; // 无效的群Id
}
