<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Messages\App;

class Sms extends Message
{
    protected $mediaId;

    protected $from;

    protected $content;

    /**
     * 图片消息.
     *
     * @param string $from 发送短信的手机号码
     * @param string $content 消息内容，支持表情，最长不超过600个字符，超出部分将自动截取
     */
    public function __construct(string $from = '', string $content = '')
    {
        $this->from = $from;
        $this->content = $content;
    }

    /**
     * 转成 array.
     * @return (string|array)[]
     */
    public function toArray()
    {
        return [
            'toUser' => $this->toUser,
            'toDept' => $this->toDept,
            'msgType' => 'sms',
            'sms' => [
                'from' => $this->from,
                'content' => $this->content,
            ],
        ];
    }
}
