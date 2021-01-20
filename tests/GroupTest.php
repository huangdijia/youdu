<?php
/**
 * This file is part of huangdijia/youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Tests;

use Huangdijia\Youdu\Group;

/**
 * @internal
 * @coversNothing
 */
class GroupTest extends TestCase
{
    /**
     * @var Group
     */
    protected $group;

    protected function setUp(): void
    {
        parent::setUp();

        $this->group = new Group($this->config);
    }

    public function testLists()
    {
        $uid = 10400;
        $groups = $this->group->lists($uid);
        // var_dump($groups);
        $this->assertIsArray($groups);
        $this->assertGreaterThan(1, count($groups));
    }

    public function testIsMember()
    {
        $groupId = '74255127-{48D3A385-66DF-4D8B-BC23-3F75C220EF2E}';
        $uid = 10400;

        $this->assertTrue($this->group->isMember($groupId, $uid));
    }
}
