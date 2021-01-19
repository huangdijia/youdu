<?php
/**
 * This file is part of huangdijia/youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Contracts;

interface DeptInterface
{
    public function create(int $id, string $name, int $parentId = 0, int $sortId = 0, string $alias = ''): int;

    public function update(int $id, string $name, int $parentId = 0, int $sortId = 0, string $alias = ''): bool;

    public function delete(int $id): bool;

    public function list(int $id): array;

    /**
     * @return array|int
     */
    public function getId(?string $alias = null);
}
