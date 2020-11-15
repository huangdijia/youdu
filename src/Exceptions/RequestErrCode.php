<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 */
namespace Huangdijia\Youdu\Exceptions;

class RequestErrCode
{
    // 请求验证
    // 错误码    十进制数值    含义
    const ERRCODE_MISS_ACCESSTOKEN = 100000; //    空的ACCESS_TOKEN

    const ERRCODE_ACCESSTOKEN_NOTEXIST = 100001; //    ACCESS_TOKEN不存在

    const ERRCODE_ACCESSTOKEN_EXPIRED = 100002; //    ACCESS_TOKEN过期

    const ERRCODE_INVALID_REQUEST = 100003; //    错误的请求

    const ERRCODE_INVALID_FORMAT_JSON = 100004; //    错误的消息格式

    const ERRCODE_INVALID_APPID = 100005; //    无效的AppId

    const ERRCODE_INVALID_ENCRYPT = 100006; //    encrypt字段解密失败

    const ERRCODE_MISS_BUIN = 100008; //    缺少企业号(buin)

    const ERRCODE_INVALID_BUIN = 100009; //    无效的企业号

    const ERRCODE_MISS_APPID = 100010; //    缺少应用ID(appId)

    const ERRCODE_MISS_ENCRYPT = 100011; //    缺少加密字段

    const ERRCODE_INVALID_FORMAT_BUIN = 100012; //    企业号字段格式不正确（int）

    const ERRCODE_INVALID_FORMAT_APPID = 100013; //    应用ID字段格式不正确(string)

    const ERRCODE_INVALID_FORMAT_ENCRYPT = 100014; //    encrypt字段格式不正确(string)
}
