<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 */
namespace Huangdijia\Youdu;

use Huangdijia\Youdu\Contracts\MediaInterface;

class Media extends Client implements MediaInterface
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
