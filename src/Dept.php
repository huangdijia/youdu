<?php
/**
 * This file is part of youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu;

use GuzzleHttp\Client;
use Huangdijia\Youdu\Constants\BaseErrCode;
use Huangdijia\Youdu\Constants\ErrCodes\GlobalErrCode;
use Huangdijia\Youdu\Formatters\UrlFormatter;
use Huangdijia\Youdu\Http\Response;
use Huangdijia\Youdu\Packer\MessagePacker;
use RuntimeException;

class Dept
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var UrlFormatter
     */
    protected $urlFormatter;

    /**
     * @var MessagePacker
     */
    protected $packer;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->client = $config->getClient();
        $this->packer = $config->getPacker();
        $this->urlFormatter = $config->getUrlFormatter();
    }

    /**
     * 获取部门列表.
     * @return array|bool
     */
    public function lists(int $parentDeptId = 0)
    {
        $response = Response::make($this->client->get($this->urlFormatter->format('/cgi/dept/list'), ['query' => ['id' => $parentDeptId]]));

        if ($response['errcode'] !== 0) {
            throw new RuntimeException($response['errmsg'], 1);
        }

        $decrypted = $this->packer->unpack($response['encrypt'] ?? '');

        return json_decode($decrypted, true)['deptList'] ?? [];
    }

    /**
     * 创建部门.
     * @param int $deptId 部门id，整型。必须大于0
     * @param string $name 部门名称。不能超过32个字符（包括汉字和英文字母）
     * @param int $parentId 父部门id。根部门id为0
     * @param int $sortId 整型。在父部门中的排序值。值越大排序越靠前。填0自动生成。同级部门不允许重复（推荐全局唯一）
     * @param string $alias 字符串。部门id的别名（通常存放以字符串表示的部门id）。唯一不为空，相同会覆盖旧数据。
     * @return int
     */
    public function create(int $deptId, string $name, int $parentId = 0, $sortId = 0, string $alias = '')
    {
        $parameters = [
            'buin' => $this->config->getBuin(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $this->packer->pack(json_encode([
                'id' => $deptId,
                'name' => $name,
                'parentId' => $parentId,
                'sortId' => $sortId,
                'alias' => $alias,
            ])),
        ];

        $response = Response::make($this->client->post($this->urlFormatter->format('/cgi/dept/create'), ['form_params' => $parameters]));

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response['httpCode'], BaseErrCode::ERRCODE_INVALID_REQUEST);
        }

        if ($response['errcode'] !== GlobalErrCode::OK) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        $decrypted = $this->packer->unpack($response['encrypt']);
        $decoded = json_decode($decrypted, true);

        return $decoded['id'];
    }

    /**
     * 更新部门.
     * @param int $deptId 部门id，整型。必须大于0
     * @param string $name 部门名称。不能超过32个字符（包括汉字和英文字母）
     * @param int $parentId 父部门id。根部门id为0
     * @param int $sortId 整型。在父部门中的排序值。值越大排序越靠前。填0自动生成。同级部门不允许重复（推荐全局唯一）
     * @param string $alias 字符串。部门id的别名（通常存放以字符串表示的部门id）。唯一不为空，相同会覆盖旧数据。
     * @return bool
     */
    public function update(int $deptId, string $name, int $parentId = 0, $sortId = 0, string $alias = '')
    {
        $parameters = [
            'buin' => $this->config->getBuin(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $this->packer->pack(json_encode([
                'id' => $deptId,
                'name' => $name,
                'parentId' => $parentId,
                'sortId' => $sortId,
                'alias' => $alias,
            ])),
        ];

        $response = Response::make($this->client->post($this->urlFormatter->format('/cgi/dept/update'), ['form_params' => $parameters]));

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response->status(), BaseErrCode::ERRCODE_INVALID_REQUEST);
        }

        if ($response['errcode'] !== GlobalErrCode::OK) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        return true;
    }

    /**
     * 更新部门.
     * @param int $deptId 部门id，整型。必须大于0
     * @return bool
     */
    public function delete(int $deptId)
    {
        $response = Response::make($this->client->get($this->urlFormatter->format('/cgi/dept/delete'), ['query' => ['id' => $deptId]]));

        if ($response['errcode'] !== 0) {
            throw new RuntimeException($response['errmsg']);
        }

        return true;
    }

    /**
     * 获取部门ID.
     * @param string $alias 部门alias。携带时查询该alias对应的部门id。不带alias参数时查询全部映射关系。
     * @return array
     */
    public function getId(string $alias = '')
    {
        $response = Response::make($this->client->get($this->urlFormatter->format('/cgi/dept/list'), ['query' => ['alias' => $alias]]));

        if ($response['errcode'] !== 0) {
            throw new RuntimeException($response['errmsg'], 1);
        }

        $decrypted = $this->packer->unpack($response['encrypt'] ?? '');

        return json_decode($decrypted, true)['aliasList'] ?? [];
    }
}
