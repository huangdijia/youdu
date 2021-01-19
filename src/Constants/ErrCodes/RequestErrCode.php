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

class RequestErrCode extends AbstractConstants
{
    /**
     * @Message("空的ACCESS_TOKEN")
     */
    const ERRCODE_MISS_ACCESSTOKEN = 100000;

    /**
     * @Message("ACCESS_TOKEN不存在")
     */
    const ERRCODE_ACCESSTOKEN_NOTEXIST = 100001;

    /**
     * @Message("ACCESS_TOKEN过期")
     */
    const ERRCODE_ACCESSTOKEN_EXPIRED = 100002;

    /**
     * @Message("错误的请求")
     */
    const ERRCODE_INVALID_REQUEST = 100003;

    /**
     * @Message("错误的消息格式")
     */
    const ERRCODE_INVALID_FORMAT_JSON = 100004;

    /**
     * @Message("无效的AppId")
     */
    const ERRCODE_INVALID_APPID = 100005;

    /**
     * @Message("encrypt字段解密失败")
     */
    const ERRCODE_INVALID_ENCRYPT = 100006;

    /**
     * @Message("缺少企业号(buin)")
     */
    const ERRCODE_MISS_BUIN = 100008;

    /**
     * @Message("无效的企业号")
     */
    const ERRCODE_INVALID_BUIN = 100009;

    /**
     * @Message("缺少应用ID(appId)")
     */
    const ERRCODE_MISS_APPID = 100010;

    /**
     * @Message("缺少加密字段")
     */
    const ERRCODE_MISS_ENCRYPT = 100011;

    /**
     * @Message("企业号字段格式不正确（int）")
     */
    const ERRCODE_INVALID_FORMAT_BUIN = 100012;

    /**
     * @Message("应用ID字段格式不正确(string)")
     */
    const ERRCODE_INVALID_FORMAT_APPID = 100013;

    /**
     * @Message("encrypt字段格式不正确(string)")
     */
    const ERRCODE_INVALID_FORMAT_ENCRYPT = 100014;
}
