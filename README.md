<h1 align="center"> Face </h1>

<p align="center">:rainbow: 基于阿里云平台的人脸识别组件。</p>


## 安装

```shell
$ composer require renfan/face -vvv
```

## 配置

> 在使用本扩展前，你需要开通阿里云人脸识别服务 [](https://face.data.aliyun.com/console)，并获取 AccessKey

输入命令添加配置文件`face.php`

`php artisan vendor:publish --provider="Renfan\Face\ServiceProvider"`

```php
return [
    'key' => env('ALI_ACCESS_KEY'),
    'secret' => env('ALI_ACCESS_KEY_SECRET'),
];
```
在 .env 文件中加入阿里云AccessKey
```php

ALI_ACCESS_KEY=xxx
ALI_ACCESS_KEY_SECRET=xxx
```

## 使用

### 图片url对比
```php
$image1 = 'a.com/1.jpg';
$image2 = 'a.com/2.jpg';
$res = app('face')->verifyByUrl($image1, $image2);
```

### 图片的base64编码对比
```php
$image1 = 'xxx';
$image2 = 'xxx';
$res = app('face')->verifyByContent($image1, $image2);
```

### 结果
```json
{
  "confidence": 99.99996948242188,
  "thresholds": [
    61,
    69,
    75
  ],
  "rectA": [
    280,
    350,
    430,
    590
  ],
  "rectB": [
    280,
    350,
    430,
    590
  ],
  "errno": 0,
  "request_id": "e1a959ba-76e6-4e02-a455-605d9e1fd421"
}

```
字段说明，见 [人脸比对API调用说明](https://help.aliyun.com/knowledge_detail/53535.html)

## License

MIT