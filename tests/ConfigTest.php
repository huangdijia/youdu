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

use Huangdijia\Youdu\Encipher\Prpcrypt;
use Huangdijia\Youdu\Formatters\UrlFormatter;
use Huangdijia\Youdu\Generators\AccessTokenGenerator;
use Huangdijia\Youdu\Http\PendingRequest;
use Huangdijia\Youdu\Packer\MessagePacker;

/**
 * @internal
 * @coversNothing
 */
class ConfigTest extends TestCase
{
    public function testGetConfigVariables()
    {
        $this->assertSame(getenv('YOUDU_API'), $this->config->getApi());
        $this->assertSame((int) getenv('YOUDU_BUIN'), $this->config->getBuin());
        $this->assertSame(getenv('YOUDU_APP_ID'), $this->config->getAppId());
        $this->assertSame(getenv('YOUDU_AES_KEY'), $this->config->getAesKey());
    }

    public function testGetHttpClient()
    {
        $this->assertInstanceOf(PendingRequest::class, $this->config->getClient());
    }

    public function testGetPacker()
    {
        $this->assertInstanceOf(MessagePacker::class, $this->config->getPacker());
    }

    public function testGetAccessTokenGenerator()
    {
        $this->assertInstanceOf(AccessTokenGenerator::class, $this->config->getAccessTokenGenerator());
    }

    public function testGetCrypter()
    {
        $this->assertInstanceOf(Prpcrypt::class, $this->config->getCrypter());
    }

    public function testGetUrlFormatter()
    {
        $this->assertInstanceOf(UrlFormatter::class, $this->config->getUrlFormatter());
    }
}
