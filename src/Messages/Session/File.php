<?php
/**
 * This file is part of huangdijia/youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Messages\Session;

class File extends Message
{
    protected $mediaId;

    protected $name;

    protected $size;

    /**
     * 文件消息.
     *
     * @param string $mediaId 素材文件id。通过上传素材文件接口获取
     * @param string $name 文件名
     * @param int $size 文件大小
     */
    public function __construct(string $mediaId = '', string $name = '', int $size = 0)
    {
        $this->mediaId = $mediaId;
        $this->name = $name;
        $this->size = $size;
    }

    public function toArray()
    {
        return [
            'sessionId' => $this->sessionId,
            'receiver' => $this->receiver,
            'sender' => $this->sender,
            'msgType' => 'file',
            'file' => [
                'media_id' => $this->mediaId,
                'name' => $this->name,
                'size' => $this->size,
            ],
        ];
    }
}
