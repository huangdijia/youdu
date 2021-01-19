<?php
/**
 * This file is part of huangdijia/youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu\Messages\App\Items;

use Huangdijia\Youdu\Contracts\Arrayable;
use Huangdijia\Youdu\Contracts\Jsonable;
use Huangdijia\Youdu\Contracts\Messages\AppMessageItem;

class Item implements AppMessageItem, Arrayable, Jsonable
{
    protected $items = [];

    /**
     * 转成 array.
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * 转成 json.
     * @param mixed $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->items, $options);
    }
}
