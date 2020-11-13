<?php

declare(strict_types=1);
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 */
namespace Huangdijia\Youdu\Contracts;

interface GroupInterface
{
    public function create(string $name): int;

    public function delete(int $groupId): bool;

    public function update(int $groupId, string $name): bool;

    public function info(int $groupId): array;

    public function list(?int $userId = null): array;
}
