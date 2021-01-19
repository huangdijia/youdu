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
use Huangdijia\Youdu\Constants\ErrCodes\GlobalErrCode;
use Huangdijia\Youdu\Formatters\UrlFormatter;
use Huangdijia\Youdu\Http\Response;
use Huangdijia\Youdu\Messages\Session\Message;
use Huangdijia\Youdu\Messages\Session\Text;
use Huangdijia\Youdu\Packer\MessagePacker;
use InvalidArgumentException;
use RuntimeException;

class Session
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
     * 创建会话.
     *
     * @param string $title 会话标题。最多允许64个字符
     * @param string $creator 会话创建者账号。最多允许64个字符
     * @param array $member 会话成员账号列表。包括创建者，多人会话的成员数必须在3人及以上
     * @param string $type 会话类型。仅支持多人会话(multi)
     * @return array
     */
    public function create(string $title, string $creator = '', array $member = [], string $type = 'multi')
    {
        if (count($member) < 3) {
            throw new InvalidArgumentException('Members too less');
        }

        $parameters = [
            'buin' => $this->config->getBuin(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $this->packer->pack(json_encode([
                'title' => $title,
                'creator' => $creator,
                'type' => $type,
                'member' => $member,
            ])),
        ];

        $member = array_map(function ($item) {
            return (string) $item;
        }, $member);

        $response = Response::make($this->client->post($this->urlFormatter->format('/cgi/session/create'), ['form_params' => $parameters]));

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response->status(), GlobalErrCode::ILLEGAL_HTTP_REQ);
        }

        if ($response['errcode'] !== GlobalErrCode::OK) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        $decrypted = $this->packer->unpack($response['encrypt']);

        return json_decode($decrypted, true);
    }

    /**
     * 修改会话.
     * @param string $sessionId 会话id
     * @param string $opUser 操作者账号
     * @param string $title 会话标题
     * @param array $addMember 新增会话成员账号列表
     * @param array $delMember 删除会话成员账号列表
     * @return array
     */
    public function update(string $sessionId, string $opUser = '', string $title = '', array $addMember = [], array $delMember = [])
    {
        $addMember = array_map(function ($item) {
            return (string) $item;
        }, $addMember);

        $delMember = array_map(function ($item) {
            return (string) $item;
        }, $delMember);

        $parameters = [
            'buin' => $this->config->getBuin(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $this->packer->pack(json_encode([
                'sessionId' => $sessionId,
                'title' => $title,
                'opUser' => $opUser,
                'addMember' => $addMember,
                'delMember' => $delMember,
            ])),
        ];

        $response = Response::make($this->client->post($this->urlFormatter->format('/cgi/session/update'), ['form_params' => $parameters]));

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response->status(), GlobalErrCode::ILLEGAL_HTTP_REQ);
        }

        if ($response['errcode'] !== 0) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        $decrypted = $this->packer->unpack($response['encrypt']);

        return json_decode($decrypted, true);
    }

    /**
     * 获取会话.
     * @return array
     */
    public function info(string $sessionId)
    {
        $response = $this->client->get($this->urlFormatter->format('/cgi/session/get'), ['query' => ['sessionId' => $sessionId]]);

        if ($response['errcode'] !== GlobalErrCode::OK) {
            throw new RuntimeException($response['errmsg'], 1);
        }

        $decrypted = $this->packer->unpack($response['encrypt'] ?? '');

        return json_decode($decrypted, true) ?? [];
    }

    /**
     * 发送会话消息.
     *
     * @throws Exception
     * @throws AccessTokenDoesNotExistException
     * @return bool
     */
    public function send(Message $message)
    {
        $parameters = [
            'buin' => $this->config->getBuin(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $this->packer->pack($message->toJson()),
        ];

        $response = Response::make($this->client->post($this->urlFormatter->format('/cgi/session/send'), ['form_params' => $parameters]));

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response->status(), GlobalErrCode::ILLEGAL_HTTP_REQ);
        }

        if ($response['errcode'] !== GlobalErrCode::OK) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        return true;
    }

    /**
     * 发送个人会话消息.
     * @param string $message
     * @return bool
     */
    public function sendToUser(string $sender, string $receiver, $message = '')
    {
        if (is_string($message)) {
            $message = new Text($message);
        }

        $message->sender($sender);
        $message->receiver($receiver);

        return $this->send($message);
    }

    /**
     * 发送多人会话消息.
     * @param string $message
     * @return bool
     */
    public function sendToSession(string $sender, string $sessionId, $message = '')
    {
        if (is_string($message)) {
            $message = new Text($message);
        }

        $message->sender($sender);
        $message->session($sessionId);

        return $this->send($message);
    }
}
