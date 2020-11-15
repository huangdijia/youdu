<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 */
namespace Huangdijia\Youdu\Contracts;

interface MediaInterface
{
    public function upload($file): string;

    public function get(string $mediaId): string;

    public function search(string $mediaId): array;
}
