<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu;

use Huangdijia\Youdu\Contracts\MediaInterface;

class Media implements MediaInterface
{
    public function upload($file): string
    {
        return '';
    }

    public function get(string $mediaId): string
    {
        return '';
    }

    public function search(string $mediaId): array
    {
        return [
            'name' => '',
            'size' => 0,
        ];
    }
}
