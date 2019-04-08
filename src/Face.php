<?php


namespace Renfan\Face;

use Renfan\Face\Exception\InvalidArgumentException;

class Face
{
    protected $key;
    protected $secret;

    /**
     * Face constructor.
     * @param $key
     * @param $secret
     */
    public function __construct($key, $secret)
    {
        $this->key = $key;
        $this->secret = $secret;
    }

    public function verifyByUrl($image1, $image2)
    {
        return $this->verify($image1, $image2, 0);
    }

    public function verifyByContent($image1, $image2)
    {
        return $this->verify($image1, $image2, 1);
    }

    public function verify($image1, $image2, $type = 0)
    {

        if (!\in_array($type, [0, 1])) {
            throw new InvalidArgumentException('Invalid type value(0/1): ' . $type);
        }
        $file = $this->aliApiAccess($this->getVerifyPostBodyByType($image1, $image2, $type), 'verify');

        return json_decode($file, true);
    }

    public function detectByUrl($image) {
        return $this->detect($image, 0);
    }

    public function detectByContent($image) {
        return $this->detect($image, 1);
    }

    public function detect($image, $type = 0) {
        if (!\in_array($type, [0, 1])) {
            throw new InvalidArgumentException('Invalid type value(0/1): ' . $type);
        }
        $file = $this->aliApiAccess($this->getDetectPostBodyByType($image, $type), 'detect');

        return json_decode($file, true);
    }

    public function attributeByUrl($image) {
        return $this->attribute($image, 0);
    }

    public function attributeByContent($image) {
        return $this->attribute($image, 1);
    }

    public function attribute($image, $type = 0) {
        if (!\in_array($type, [0, 1])) {
            throw new InvalidArgumentException('Invalid type value(0/1): ' . $type);
        }
        $file = $this->aliApiAccess($this->getAttributePostBodyByType($image, $type), 'attribute');

        return json_decode($file, true);
    }

    /**
     * 阿里云api校验
     * @param $content
     * @param $path [Api地址]
     * @return false|string
     * @throws InvalidArgumentException
     */
    public function aliApiAccess($content, $path) {
        if (!\in_array($path, ['detect', 'attribute', 'verify'])) {
            throw new InvalidArgumentException('Invalid type value(detect, attribute, verify): ' . $path);
        }

        $url = 'https://dtplus-cn-shanghai.data.aliyuncs.com/face/' . $path;
        $options = array(
            'http' => array(
                'header' => array(
                    'accept' => "application/json",
                    'content-type' => "application/json",
                    'date' => gmdate("D, d M Y H:i:s \G\M\T"),
                    'authorization' => ''
                ),
                'method' => "POST", //可以是 GET, POST, DELETE, PUT
                'content' => $content //如有数据，请用json_encode()进行编码
            )
        );
        $http = $options['http'];
        $header = $http['header'];
        $urlObj = parse_url($url);
        if (empty($urlObj["query"]))
            $path = $urlObj["path"];
        else
            $path = $urlObj["path"] . "?" . $urlObj["query"];
        $body = $http['content'];
        if (empty($body))
            $bodymd5 = $body;
        else
            $bodymd5 = base64_encode(md5($body, true));
        $stringToSign = $http['method'] . "\n" . $header['accept'] . "\n" . $bodymd5 . "\n" . $header['content-type'] . "\n" . $header['date'] . "\n" . $path;
        $signature = base64_encode(
            hash_hmac(
                "sha1",
                $stringToSign,
                $this->secret, true));
        $authHeader = "Dataplus " . "{$this->key}" . ":" . "$signature";
        $options['http']['header']['authorization'] = $authHeader;
        $options['http']['header'] = implode(
            array_map(
                function ($key, $val) {
                    return $key . ":" . $val . "\r\n";
                },
                array_keys($options['http']['header']),
                $options['http']['header']));
        $context = stream_context_create($options);
        $file = file_get_contents($url, false, $context);
        return $file;
    }

    /**
     * @param $image1
     * @param $image2
     * @param $type
     * @return false|string
     */
    public function getVerifyPostBodyByType($image1, $image2, $type = 0)
    {
        if ($type == 0) {
            $body = [
                'type' => $type,
                'image_url_1' => $image1,
                'image_url_2' => $image2
            ];
        } else {
            $body = [
                'type' => $type,
                'content_1' => $image1,
                'content_2' => $image2
            ];
        }
        return json_encode($body);
    }

    public function getDetectPostBodyByType($image, $type = 0) {
        if ($type == 0) {
            $body = [
                'type' => $type,
                'image_url' => $image
            ];
        } else {
            $body = [
                'type' => $type,
                'content' => $image
            ];
        }
        return json_encode($body);
    }


    public function getAttributePostBodyByType($image, $type = 0) {
        if ($type == 0) {
            $body = [
                'type' => $type,
                'image_url' => $image
            ];
        } else {
            $body = [
                'type' => $type,
                'content' => $image
            ];
        }
        return json_encode($body);
    }
}