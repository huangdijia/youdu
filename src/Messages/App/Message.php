<?php
/**
 * This file is part of huangdijia/youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Messages\App;

use Huangdijia\Youdu\Contracts\Messages\AppMessage;
use Huangdijia\Youdu\Contracts\Support\Arrayable;
use Huangdijia\Youdu\Contracts\Support\Jsonable;
use Huangdijia\Youdu\Contracts\Support\Whenable;
use JsonSerializable;

abstract class Message implements AppMessage, Arrayable, Jsonable, JsonSerializable, Whenable
{
    /**
     * @var string
     */
    protected $toUser;

    /**
     * @var string
     */
    protected $toDept;

    /**
     * 发送至用户.
     */
    public function toUser(string $toUser)
    {
        // 兼容用,隔开
        $toUser = strtr($toUser, ',', '|');
        $this->toUser = $toUser;
    }

    /**
     * 发送至部门.
     */
    public function toDept(string $toDept)
    {
        // 兼容用,隔开
        $toDept = strtr($toDept, ',', '|');
        $this->toDept = $toDept;
    }

    /**
     * 转成 json.
     * @param int $options
     * @return false|string
     */
    public function toJson($options = JSON_UNESCAPED_UNICODE)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * json 序列化.
     * @return array
     */
    public function jsonSerialize()
    {
        $data = $this->toArray();

        if (is_null($this->toUser)) {
            unset($data['toUser']);
        }

        if (is_null($this->toDept)) {
            unset($data['toDept']);
        }

        return $data;
    }

    public function when($value, $callback, $default = null)
    {
        if ($value) {
            return $callback($this, $value) ?: $this;
        }

        if ($default) {
            return $default($this, $value) ?: $this;
        }

        return $this;
    }
}
