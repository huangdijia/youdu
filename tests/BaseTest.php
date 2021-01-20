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

/**
 * @internal
 * @coversNothing
 */
class BaseTest extends TestCase
{
    public function testUrlFormatter()
    {
        $this->assertMatchesRegularExpression('/\?accessToken=[0-9a-f]{32}/', $this->config->getUrlFormatter()->format('/cgi/user/simplelist'));
    }

    public function testPacker()
    {
        $data = json_encode(['a' => 1]);
        $packed = $this->config->getPacker()->pack($data);

        $this->assertSame($data, $this->config->getPacker()->unpack($packed));
    }
}
