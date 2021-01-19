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
use Huangdijia\Youdu\Formatters\UrlFormatter;
use Huangdijia\Youdu\Http\PendingRequest;
use Huangdijia\Youdu\Packer\MessagePacker;
use RuntimeException;
use Throwable;

class User
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
     * 获取用户列表.
     * @return array
     */
    public function simpleList(?int $deptId = 0)
    {
        $response = $this->client->get($this->urlFormatter->format('/cgi/user/simplelist'), ['deptId' => $deptId]);

        if ($response['errcode'] !== GlobalErrCode::OK) {
            throw new RuntimeException($response['errmsg']);
        }

        $decrypted = $this->packer->unpack($response['encrypt'] ?? '');

        return json_decode($decrypted, true)['userList'] ?? [];
    }

    /**
     * 获取用户列表.
     * @return array
     */
    public function lists(?int $deptId = 0)
    {
        $response = $this->client->get($this->urlFormatter->format('/cgi/user/list'), ['deptId' => $deptId]);

        if ($response['errcode'] !== GlobalErrCode::OK) {
            throw new RuntimeException($response['errmsg'], 1);
        }

        $decrypted = $this->packer->unpack($response['encrypt'] ?? '');

        return json_decode($decrypted, true)['userList'] ?? [];
    }

    /**
     * 创建用户.
     * @param int|string $userId 用户id(帐号)，企业内必须唯一。长度为1~64个字符（包括汉字和英文字母）
     * @param string $name 用户名称。长度为0~64个字符（包括汉字和英文字母，可为空）
     * @param int $gender 性别，整型。0表示男性，1表示女性
     * @param string $mobile 手机号码。企业内必须唯一
     * @param string $phone 电话号码
     * @param string $email 邮箱。长度为0~64个字符
     * @param array $dept 所属部门列表,不超过20个
     * @return bool
     */
    public function create($userId, string $name, int $gender = 0, string $mobile = '', string $phone = '', string $email = '', array $dept = [])
    {
        $parameters = [
            'buin' => $this->config->getBuin(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $this->packer->pack(json_encode([
                'userId' => $userId,
                'name' => $name,
                'gender' => $gender,
                'mobile' => $mobile,
                'phone' => $phone,
                'email' => $email,
                'dept' => $dept,
            ])),
        ];

        $response = $this->client->post($this->urlFormatter->format('/cgi/user/create'), $parameters);

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response->status(), GlobalErrCode::ILLEGAL_HTTP_REQ);
        }

        if ($response['errcode'] !== GlobalErrCode::OK) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        return true;
    }

    /**
     * 更新用户.
     * @param int|string $userId 用户id(帐号)，企业内必须唯一。长度为1~64个字符（包括汉字和英文字母）
     * @param string $name 用户名称。长度为0~64个字符（包括汉字和英文字母，可为空）
     * @param int $gender 性别，整型。0表示男性，1表示女性
     * @param string $mobile 手机号码。企业内必须唯一
     * @param string $phone 电话号码
     * @param string $email 邮箱。长度为0~64个字符
     * @param array $dept 所属部门列表,不超过20个
     * @return bool
     */
    public function update($userId, string $name, int $gender = 0, string $mobile = '', string $phone = '', string $email = '', array $dept = [])
    {
        $parameters = [
            'buin' => $this->config->getBuin(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $this->packer->pack(json_encode([
                'userId' => $userId,
                'name' => $name,
                'gender' => $gender,
                'mobile' => $mobile,
                'phone' => $phone,
                'email' => $email,
                'dept' => $dept,
            ])),
        ];

        $response = $this->client->post($this->urlFormatter->format('/cgi/user/update'), $parameters);

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response->status(), GlobalErrCode::ILLEGAL_HTTP_REQ);
        }

        if ($response['errcode'] !== GlobalErrCode::OK) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        return true;
    }

    /**
     * 更新职位信息.
     * @param int|string $userId 用户id(帐号)，企业内必须唯一。长度为1~64个字符（包括汉字和英文字母）
     * @param int $deptId 部门Id。用户必须在该部门内
     * @param string $position 职务
     * @param int $weight 职务权重。用户拥有多个职务时，权重值越大的职务排序越靠前
     * @param int $sortId 用户在部门中的排序，值越大排序越靠前
     * @return bool
     */
    public function updatePosition($userId, int $deptId, string $position = '', int $weight = 0, int $sortId = 0)
    {
        $parameters = [
            'buin' => $this->config->getBuin(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $this->packer->pack(json_encode([
                'userId' => $userId,
                'deptId' => $deptId,
                'position' => $position,
                'weight' => $weight,
                'sortId' => $sortId,
            ])),
        ];

        $response = $this->client->post($this->urlFormatter->format('/cgi/user/positionupdate'), $parameters);

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response->status(), GlobalErrCode::ILLEGAL_HTTP_REQ);
        }

        if ($response['errcode'] !== 0) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        return true;
    }

    /**
     * 删除用户.
     *
     * @param array|int $userId
     * @return bool
     */
    public function delete($userId)
    {
        // batch delete
        if (is_array($userId)) {
            $parameters = [
                'buin' => $this->config->getBuin(),
                'appId' => $this->config->getAppId(),
                'encrypt' => $this->packer->pack(json_encode([
                    'delList' => $userId,
                ])),
            ];

            $response = $this->client->post($this->urlFormatter->format('/cgi/user/batchdelete'), $parameters);

            if (! $response->ok()) {
                throw new RuntimeException('http request code ' . $response->status(), GlobalErrCode::ILLEGAL_HTTP_REQ);
            }

            if ($response['errcode'] !== 0) {
                throw new RuntimeException($response['errmsg'], $response['errcode']);
            }

            return true;
        }

        // single delete
        $response = $this->client->get($this->urlFormatter->format('/cgi/user/delete'), ['userId' => $userId]);

        if ($response['errcode'] !== GlobalErrCode::OK) {
            throw new RuntimeException($response['errmsg']);
        }

        return true;
    }

    /**
     * 用户详情.
     * @param int|string $userId
     * @return array
     */
    public function get($userId)
    {
        $response = $this->client->get($this->urlFormatter->format('/cgi/user/get'), ['userId' => $userId]);

        if ($response['errcode'] !== GlobalErrCode::OK) {
            throw new RuntimeException($response['errmsg']);
        }

        $decrypted = $this->packer->unpack($response['encrypt'] ?? '');

        return json_decode($decrypted, true) ?? [];
    }

    /**
     * 设置认证信息.
     *
     * @param int|string $userId
     * @param int $authType 认证方式：0本地认证，2第三方认证
     * @param string $passwd 原始密码md5加密后转16进制的小写字符串
     * @return bool
     */
    public function setAuth($userId, int $authType = 0, string $passwd = '')
    {
        // md5 -> hex -> lower
        $passwd = strtolower(bin2hex(md5($passwd)));

        $parameters = [
            'buin' => $this->config->getBuin(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $this->packer->pack(json_encode([
                'userId' => $userId,
                'authType' => $authType,
                'passwd' => $passwd,
            ])),
        ];

        $response = $this->client->post($this->urlFormatter->format('/cgi/user/setauth'), $parameters);

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response['httpCode'], GlobalErrCode::ILLEGAL_HTTP_REQ);
        }

        if ($response['errcode'] !== GlobalErrCode::OK) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        return true;
    }

    /**
     * 设置头像.
     * @param int|string $userId
     * @return bool
     */
    public function setAvatar($userId, string $file)
    {
        if (preg_match('/^https?:\/\//i', $file)) { // 远程文件
            $contextOptions = stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);

            $originalContent = file_get_contents($file, false, $contextOptions);
        } else { // 本地文件
            $originalContent = file_get_contents($file);
        }

        // 加密文件
        $tmpFile = '/tmp/youdu_' . str_random();
        $encryptedFile = $this->packer->pack($originalContent);
        $encryptedMsg = $this->packer->pack(json_encode([
            'type' => 'image',
            'name' => basename($file),
        ]));

        // 保存加密文件
        if (file_put_contents($tmpFile, $encryptedFile) === false) {
            throw new RuntimeException('Create tmpfile faild', 1);
        }

        // 封装上传参数
        $parameters = [
            ['name' => 'userId', 'contents' => $userId],
            ['name' => 'file', 'contents' => fopen(realpath($tmpFile), 'r')],
            ['name' => 'encrypt', 'contents' => $encryptedMsg],
            ['name' => 'buin', 'contents' => $this->config->getBuin()],
            ['name' => 'appId', 'contents' => $this->config->getAppId()],
        ];

        try {
            // 开始上传
            $response = $this->client->post($this->urlFormatter->format('/cgi/avatar/set'), $parameters, 'multipart');

            if ($response['errcode'] !== GlobalErrCode::OK) {
                throw new RuntimeException($response['errmsg'], $response['errcode']);
            }
        } catch (Throwable $e) {
            throw $e;
        } finally {
            unlink($tmpFile);
        }

        return true;
    }

    /**
     * 获取头像（头像二进制数据）.
     *
     * @param int|string $userId
     * @return string
     */
    public function getAvatar($userId, int $size = 0)
    {
        $response = $this->client->get($this->urlFormatter->format('/cgi/avatar/get'), ['userId' => $userId, 'size' => $size]);

        return $this->packer->unpack($response->body() ?? '');
    }

    /**
     * 单点登录.
     *
     * @return array
     */
    public function identify(string $token)
    {
        $response = $this->client->get($this->urlFormatter->format('/cgi/identify', false), ['token' => $token]);

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response->status(), GlobalErrCode::ILLEGAL_HTTP_REQ);
        }

        if ($response->json('status.code', 0) != GlobalErrCode::OK) {
            throw new RuntimeException($response->json('status.message', ''));
        }

        return $response['userInfo'] ?? [];
    }
}
