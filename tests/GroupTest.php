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

    /**
     * @var string
     */
    protected $testUserId;

    /**
     * @var string
     */
    protected $testGroupId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->group = new Group($this->config);
        $this->testGroupId = getenv('YOUDU_GROUP_ID');
        $this->testUserId = getenv('YOUDU_USER_ID');
    }

    public function testLists()
    {
        $groups = $this->group->lists($this->testUserId);
        // var_dump($groups);
        $this->assertIsArray($groups);
        $this->assertGreaterThan(1, count($groups));
    }

    public function testIsMember()
    {
        $this->assertTrue($this->group->isMember($this->testGroupId, $this->testUserId));
    }
}
