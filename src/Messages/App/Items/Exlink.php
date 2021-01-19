<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Messages\App\Items;

class Exlink extends Item
{
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @param string $title 标题。最多允许64个字节
     * @param string $url 链接
     * @param string $digest 摘要，最长不超过120个字符，超出部分将自动截取
     * @param string $mediaId 封面图片的ID。通过上传素材文件接口获取
     */
    public function add(string $title = '', string $url = '', string $digest = '', string $mediaId = '')
    {
        $this->items[] = [
            'title' => $title,
            'url' => $url,
            'digest' => $digest,
            'media_id' => $mediaId,
        ];
    }
}
