<?php
/**
 * This file is part of huangdijia/youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Formatters;

use GuzzleHttp\Exception\GuzzleException;
use Huangdijia\Youdu\Config;
use Huangdijia\Youdu\Generators\AccessTokenGenerator;
use RuntimeException;

class UrlFormatter
{
    /**
     * @var AccessTokenGenerator
     */
    protected $accessTokenGenerator;

    public function __construct(Config $config)
    {
        $this->accessTokenGenerator = $config->getAccessTokenGenerator();
    }

    /**
     * @throws RuntimeException
     * @throws GuzzleException
     * @return string
     */
    public function format(string $url, bool $appendToken = true)
    {
        if (! $appendToken) {
            return $url;
        }

        return sprintf(
            '%s%saccessToken=%s',
            $url,
            (strpos($url, '?') == false ? '?' : '&'),
            $this->accessTokenGenerator->get()
        );
    }
}
