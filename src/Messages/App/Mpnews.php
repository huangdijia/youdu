<?php
/**
 * This file is part of huangdijia/youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Messages\App;

class Mpnews extends Message
{
    protected $mpnews;

    /**
     * 图文消息.
     *
     * @param \Huangdijia\Youdu\Messages\App\Items\Mpnews $mpnews 消息内容，支持表情，最长不超过600个字符，超出部分将自动截取
     */
    public function __construct(Items\Mpnews $mpnews)
    {
        $this->mpnews = $mpnews;
    }

    /**
     * 转成 array.
     * @return array
     */
    public function toArray()
    {
        return [
            'toUser' => $this->toUser,
            'toDept' => $this->toDept,
            'msgType' => 'mpnews',
            'mpnews' => $this->mpnews->toArray(),
        ];
    }
}
