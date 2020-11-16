<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Contracts;

use Huangdijia\Youdu\Contracts\Messages\SessionMessage;

interface SessionInterface
{
    public function create(string $title, int $creator, array $members, string $type = 'multi'): array;

    public function get(string $sessionId): array;

    public function update(string $sessionId, int $opUser, string $title = '', array $addMembers = [], array $delMembers = []): array;

    public function send(SessionMessage $message): bool;
}
