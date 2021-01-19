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

class Text extends Message
{
    protected $content;

    /**
     * 文本消息.
     *
     * @param string $content 消息内容，支持表情，最长不超过600个字符，超出部分将自动截取
     */
    public function __construct(string $content = '')
    {
        $this->content = $content;
    }

    /**
     * 转成 array.
     * @return (string|string[])[]
     */
    public function toArray()
    {
        return [
            'toUser' => $this->toUser,
            'toDept' => $this->toDept,
            'msgType' => 'text',
            'text' => [
                'content' => $this->content,
            ],
        ];
    }
}
