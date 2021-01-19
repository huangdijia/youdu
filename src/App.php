<?php
/**
 * This file is part of huangdijia/youdu-client.
 *
 * @link     https://github.com/huangdijia/youdu-client
 * @document https://github.com/huangdijia/youdu-client
 * @contact  huangdijia@gmail.com
 * @link     https://youdu.im/api/api.html#40011
 */
namespace Huangdijia\Youdu;

use GuzzleHttp\Exception\GuzzleException;
use Huangdijia\Youdu\Constants\BaseErrCode;
use Huangdijia\Youdu\Formatters\UrlFormatter;
use Huangdijia\Youdu\Http\PendingRequest;
use Huangdijia\Youdu\Messages\App\Message;
use Huangdijia\Youdu\Messages\App\PopWindow;
use Huangdijia\Youdu\Messages\App\SysMsg;
use Huangdijia\Youdu\Messages\App\Text;
use Huangdijia\Youdu\Packer\MessagePacker;
use InvalidArgumentException;
use RuntimeException;

class App
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
     * 发送应用消息.
     * @throws RuntimeException
     * @throws GuzzleException
     * @return true
     */
    public function send(Message $message)
    {
        $encrypted = $this->packer->pack($message->toJson());
        $parameters = [
            'buin' => $this->config->getBuin(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $encrypted,
        ];

        $url = $this->urlFormatter->format('/cgi/msg/send');
        $response = $this->client->post($url, $parameters);

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response->status(), BaseErrCode::INVALID_REQUEST);
        }

        if ($response['errcode'] !== BaseErrCode::OK) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        return true;
    }

    /**
     * 发送消息给用户.
     * @param string $toUser 接收成员的帐号列表。多个接收者用竖线分隔，最多支持1000个
     * @param \Huangdijia\Youdu\Messages\App\Message|string $message
     * @return bool
     */
    public function sendToUser(string $toUser = '', $message = '')
    {
        if (is_string($message)) {
            $message = new Text($message);
        }

        $message->toUser($toUser);

        return $this->send($message);
    }

    /**
     * 发送消息至部门.
     * @param string $toDept $toDept 接收部门id列表。多个接收者用竖线分隔，最多支持100个
     * @param \Huangdijia\Youdu\Messages\App\Message|string $message
     * @throws RuntimeException
     * @throws GuzzleException
     * @return bool
     */
    public function sendToDept(string $toDept = '', $message = '')
    {
        if (is_string($message)) {
            $message = new Text($message);
        }

        $message->toDept($toDept);

        return $this->send($message);
    }

    /**
     * 发送系统消息.
     * @param mixed $message
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws GuzzleException
     * @return true
     */
    public function sendToAll($message, bool $onlineOnly = false)
    {
        if (is_string($message)) {
            $items = new Messages\App\Items\SysMsg();
            $items->addText($message);
            $message = new SysMsg($items);
        }

        if (! ($message instanceof SysMsg)) {
            throw new InvalidArgumentException('$message must instanceof' . SysMsg::class);
        }

        $message->toAll($onlineOnly);

        return $this->send($message);
    }

    /**
     * 设置通知数.
     * @throws RuntimeException
     * @throws GuzzleException
     * @return true
     */
    public function setNoticeCount(string $account = '', string $tip = '', int $msgCount = 0)
    {
        $parameters = [
            'app_id' => $this->config->getAppId(),
            'msg_encrypt' => $this->packer->pack(json_encode([
                'account' => $account,
                'tip' => $tip,
                'count' => $msgCount,
            ])),
        ];

        $response = $this->client->post($this->urlFormatter->format('/cgi/set.ent.notice'), $parameters);

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response->status(), BaseErrCode::INVALID_REQUEST);
        }

        if ($response['errcode'] !== BaseErrCode::OK) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        return true;
    }

    /**
     * 应用弹窗.
     * @throws RuntimeException
     * @throws GuzzleException
     * @return true
     */
    public function popWindow(string $toUser = '', string $toDept = '', PopWindow $message)
    {
        $message->when($toUser, function ($message, $toUser) {
            $message->toUser($toUser);
        });

        $message->when($toDept, function ($message, $toDept) {
            $message->toDept($toDept);
        });

        $parameters = [
            'app_id' => $this->config->getAppId(),
            'msg_encrypt' => $this->packer->pack($message->toJson()),
        ];

        $response = $this->client->post($this->urlFormatter->format('/cgi/popwindow'), ['form_params' => $parameters]);

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response->status(), BaseErrCode::INVALID_REQUEST);
        }

        if ($response['errcode'] !== BaseErrCode::OK) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        return true;
    }
}
