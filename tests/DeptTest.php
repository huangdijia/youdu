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

use Huangdijia\Youdu\Dept;

/**
 * @internal
 * @coversNothing
 */
class DeptTest extends TestCase
{
    /**
     * @var Dept
     */
    protected $dept;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dept = new Dept($this->config);
    }

    public function testLists()
    {
        $lists = $this->dept->lists(0);
        $this->assertIsArray($lists);
        $this->assertGreaterThan(1, count($lists));
    }
}
