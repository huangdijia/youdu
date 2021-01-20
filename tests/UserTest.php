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

use Huangdijia\Youdu\User;

/**
 * @internal
 * @coversNothing
 */
class UserTest extends TestCase
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $testUserId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = new User($this->config);
        $this->testUserId = getenv('YOUDU_USER_ID');
    }

    public function testSimpleList()
    {
        $users = $this->user->simpleList(1);
        $this->assertIsArray($users);
        $this->assertGreaterThan(1, count($users));
    }

    public function testUserInfo()
    {
        $user = $this->user->get($this->testUserId);

        $this->assertArrayHasKey('userId', $user);
        $this->assertSame($this->testUserId, $user['userId']);
    }
}
