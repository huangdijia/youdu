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

use Huangdijia\Youdu\Constants\ErrCodes\GlobalErrCode;
use Huangdijia\Youdu\Constants\ErrCodes\GroupErrCode;
use Huangdijia\Youdu\Formatters\UrlFormatter;
use Huangdijia\Youdu\Http\PendingRequest;
use Huangdijia\Youdu\Packer\MessagePacker;
use RuntimeException;

class Group
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var PendingRequest
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
     * 获取群列表.
     *
     * @param int|string $userId
     * @return array
     */
    public function lists($userId = '')
    {
        $parameters = [];

        if ($userId) {
            $parameters['userId'] = $userId;
        }

        $response = $this->client->get($this->urlFormatter->format('/cgi/group/list'), $parameters);

        if ($response['errcode'] !== GroupErrCode::OK) {
            throw new RuntimeException($response['errmsg']);
        }

        $decrypted = $this->packer->unpack($response['encrypt'] ?? '');

        return json_decode($decrypted, true)['groupList'] ?? [];
    }

    /**
     * 创建群.
     *
     * @return int|string
     */
    public function create(string $name)
    {
        $parameters = [
            'buin' => $this->config->getBuin(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $this->packer->pack(json_encode([
                'name' => $name,
            ])),
        ];

        $response = $this->client->post($this->urlFormatter->format('/cgi/group/create'), $parameters);

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response->status(), GlobalErrCode::ILLEGAL_HTTP_REQ);
        }

        if ($response['errcode'] !== GroupErrCode::OK) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        $decrypted = $this->packer->unpack($response['encrypt']);
        $decoded = json_decode($decrypted, true);

        return $decoded['id'];
    }

    /**
     * 删除群.
     *
     * @return bool
     */
    public function delete(string $groupId)
    {
        $response = $this->client->get($this->urlFormatter->format('/cgi/group/delete'), ['groupId' => $groupId]);

        if ($response['errcode'] !== GroupErrCode::OK) {
            throw new RuntimeException($response['errmsg']);
        }

        return true;
    }

    /**
     * 修改群名称.
     *
     * @return bool
     */
    public function update(string $groupId, string $name)
    {
        $parameters = [
            'buin' => $this->config->getBuin(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $this->packer->pack(json_encode([
                'id' => $groupId,
                'name' => $name,
            ])),
        ];

        $response = $this->client->post($this->urlFormatter->format('/cgi/group/update'), $parameters);

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response['httpCode'], GlobalErrCode::ILLEGAL_HTTP_REQ);
        }

        if ($response['errcode'] !== GroupErrCode::OK) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        return true;
    }

    /**
     * 查看群信息.
     *
     * @return array
     */
    public function info(string $groupId)
    {
        $response = $this->client->get($this->urlFormatter->format('/cgi/group/info'), ['id' => $groupId]);

        if ($response['errcode'] !== GroupErrCode::OK) {
            throw new RuntimeException($response['errmsg']);
        }

        $decrypted = $this->packer->unpack($response['encrypt'] ?? '');

        return json_decode($decrypted, true) ?? [];
    }

    /**
     * 添加群成员.
     *
     * @return bool
     */
    public function addMember(string $groupId, array $members = [])
    {
        $parameters = [
            'buin' => $this->config->getBuin(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $this->packer->pack(json_encode([
                'id' => $groupId,
                'userList' => $members,
            ])),
        ];

        $response = $this->client->post($this->urlFormatter->format('/cgi/group/addmember'), $parameters);

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response['httpCode'], GlobalErrCode::ILLEGAL_HTTP_REQ);
        }

        if ($response['errcode'] !== GroupErrCode::OK) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        return true;
    }

    /**
     * 删除群成员.
     *
     * @return bool
     */
    public function delMember(string $groupId, array $members = [])
    {
        $parameters = [
            'encrypt' => $this->packer->pack(json_encode([
                'id' => $groupId,
                'userList' => $members,
            ])),
        ];

        $response = $this->client->post($this->urlFormatter->format('/cgi/group/delmember'), $parameters);

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response->status(), GlobalErrCode::ILLEGAL_HTTP_REQ);
        }

        if ($response['errcode'] !== 0) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        return true;
    }

    /**
     * 查询用户是否是群成员.
     *
     * @param int|string $userId
     * @return bool
     */
    public function isMember(string $groupId, $userId)
    {
        $response = $this->client->get($this->urlFormatter->format('/cgi/group/ismember'), ['id' => $groupId, 'userId' => $userId]);

        if ($response['errcode'] !== GroupErrCode::OK) {
            throw new RuntimeException($response['errmsg'], 1);
        }

        $decrypted = $this->packer->unpack($response['encrypt'] ?? '');

        return json_decode($decrypted, true)['belong'] ?? false;
    }
}
