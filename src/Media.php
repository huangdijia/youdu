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

use Huangdijia\Youdu\Constants\ErrCodes\GlobalErrCode;
use Huangdijia\Youdu\Formatters\UrlFormatter;
use Huangdijia\Youdu\Http\PendingRequest;
use Huangdijia\Youdu\Packer\MessagePacker;
use RuntimeException;
use Throwable;

class Media
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
     * 上传文件.
     *
     * @param string $fileType image代表图片、file代表普通文件、voice代表语音、video代表视频
     * @return string
     */
    public function upload(string $file = '', string $fileType = 'file')
    {
        if (! in_array($fileType, ['file', 'voice', 'video', 'image'])) {
            throw new RuntimeException('Unsupport file type ' . $fileType, 1);
        }

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
            'type' => $fileType ?? 'file',
            'name' => basename($file),
        ]));

        // 保存加密文件
        if (file_put_contents($tmpFile, $encryptedFile) === false) {
            throw new RuntimeException('Create tmpfile faild', 1);
        }

        // 封装上传参数
        $parameters = [
            ['name' => 'file', 'contents' => fopen($tmpFile, 'r')],
            ['name' => 'encrypt', 'contents' => $encryptedMsg],
            ['name' => 'buin', 'contents' => $this->config->getBuin()],
            ['name' => 'appId', 'contents' => $this->config->getAppId()],
        ];

        try {
            // 开始上传
            $response = $this->client->post($this->urlFormatter->format('/cgi/media/upload'), $parameters, 'multipart');

            // 出错后删除加密文件
            if ($response['errcode'] !== GlobalErrCode::OK) {
                throw new RuntimeException($response['errmsg'], $response['errcode']);
            }

            $decrypted = $this->packer->unpack($response['encrypt']);
            $decoded = json_decode($decrypted, true);

            if (empty($decoded['mediaId'])) {
                throw new RuntimeException('mediaId is empty');
            }

            return $decoded['mediaId'];
        } catch (Throwable $e) {
            throw $e;
        } finally {
            // 删除加密文件
            unlink($tmpFile);
        }
    }

    /**
     * 下载文件.
     * @return bool|string
     */
    public function get(string $mediaId = '', string $savePath = null)
    {
        $encrypted = $this->packer->pack(json_encode(['mediaId' => $mediaId]));
        $parameters = [
            'buin' => $this->config->getBuin(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $encrypted,
        ];

        $response = $this->client->post($this->urlFormatter->format('/cgi/media/get'), $parameters);
        $fileInfo = $this->packer->unpack($response->header('Encrypt'));
        $fileInfo = json_decode($fileInfo, true);

        $fileContent = $this->packer->unpack($response['body']);

        if (is_null($savePath)) {
            return $fileContent;
        }

        if (! is_writable($savePath)) {
            throw new RuntimeException($savePath . ' is not writable!');
        }

        $saveAs = rtrim($savePath, '/') . '/' . $fileInfo['name'];
        $saved = file_put_contents($saveAs, $fileContent);

        if (! $saved) {
            throw new RuntimeException('save faild');
        }

        return true;
    }

    /**
     * 素材文件信息.
     * @return array
     */
    public function info(string $mediaId = '')
    {
        $encrypted = $this->packer->pack(json_encode(['mediaId' => $mediaId]));
        $parameters = [
            'buin' => $this->config->getBuin(),
            'appId' => $this->config->getAppId(),
            'encrypt' => $encrypted,
        ];

        $response = $this->client->post($this->urlFormatter->format('/cgi/media/search'), $parameters);

        if (! $response->ok()) {
            throw new RuntimeException('http request code ' . $response->status(), GlobalErrCode::ILLEGAL_HTTP_REQ);
        }

        if ($response['errcode'] !== 0) {
            throw new RuntimeException($response['errmsg'], $response['errcode']);
        }

        if ($response['errcode'] !== 0) {
            throw new RuntimeException($response['errmsg'], 1);
        }

        $decrypted = $this->packer->pack($response['encrypt'] ?? '');

        return json_decode($decrypted, true);
    }
}
