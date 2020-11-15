<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 */
namespace Huangdijia\Youdu\Contracts;

interface SessionInterface
{
    public function create(string $title, int $creator, array $members, string $type = 'multi'): array;

    public function get(string $sessionId): array;

    public function update(string $sessionId, int $opUser, string $title = '', array $addMembers = [], array $delMembers = []): array;
}
