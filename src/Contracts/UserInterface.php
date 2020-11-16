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

interface UserInterface
{
    public function create(string $userId, string $name, int $gender, string $mobile = '', string $phone = '', string $email = '', array $dept = []): bool;

    public function update(string $userId, string $name, int $gender, string $mobile = '', string $phone = '', string $email = '', array $dept = []): bool;

    public function updatePosition(string $userId, int $deptId, string $position = '', int $weight = 0, int $sortId = 0): bool;

    public function delete(string $userId): bool;

    public function batchDelete(array $delList): bool;

    public function get(string $userId): array;

    public function simplelist(int $deptId): array;

    public function list(int $deptId): array;

    public function setAuth(string $userId, $authType, $passwd): bool;

    public function setAvatar(string $userId, $file): bool;

    public function getAvatar(string $userId): string;
}
