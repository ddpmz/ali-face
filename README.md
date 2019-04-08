<h1 align="center"> Face </h1>

<p align="center">:rainbow: 基于阿里云平台的人脸识别组件。</p>

[![Latest Version on Packagist](https://img.shields.io/packagist/v/renfan/face.svg?style=flat-square)](https://packagist.org/packages/renfan/face)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://travis-ci.org/renfan/face.svg?branch=master)](https://travis-ci.org/renfan/face)
![StyleCI build status](https://github.styleci.io/repos/180088039/shield) 

## 安装

```shell
$ composer require renfan/face -vvv
```

## 配置

> 在使用本扩展前，你需要开通阿里云人脸识别服务 [](https://face.data.aliyun.com/console)，并获取 AccessKey

输入命令添加配置文件`face.php`

```php
php artisan vendor:publish --provider="Renfan\Face\ServiceProvider"
```
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

### 图片对比 `verify`

#### url 方式
```php
$image1 = 'a.com/1.jpg';
$image2 = 'a.com/2.jpg';
$res = app('face')->verifyByUrl($image1, $image2);
```

#### base64 方式
```php
$image1 = 'xxx';
$image2 = 'xxx';
$res = app('face')->verifyByContent($image1, $image2);
```

#### 结果
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

### 人脸检测定位

#### url 方式

```php
$image = 'a.com/1.jpg';
$res = app('face')->detectByUrl($image);
```

#### base64 方式

```php
$image = 'xxxx';
$res = app('face')->detectByContent($image);
```

#### 结果
```json
{
  "face_num": 1,
  "face_rect": [
    280,
    350,
    430,
    590
  ],
  "face_prob": [
    1
  ],
  "pose": [
    0.20114891231060028,
    -0.4934055507183075,
    0.7045236229896545
  ],
  "landmark_num": 105,
  "landmark": [
    290.78765869140625,
    549.17578125
  ],
  "iris": [
    391.3370666503906,
    577.3011474609375,
    17.18027114868164,
    593.888916015625,
    577.9119873046875,
    17.18027114868164
  ],
  "errno": 0,
  "request_id": "3a91b868-5af9-4980-a088-54cbacf2e40b"
}

```
字段说明，见 [人脸检测定位API调用说明](https://help.aliyun.com/knowledge_detail/53399.html)

### 人脸属性识别

#### url 方式

```php
$image = 'a.com/1.jpg';
$res = app('face')->attributeByUrl($image);
```

#### base64 方式

```php
$image = 'xxxx';
$res = app('face')->attributeByContent($image);
```

#### 结果
```json
{
  "face_num": 1,
  "face_rect": [
    280,
    350,
    430,
    590
  ],
  "face_prob": [
    1
  ],
  "pose": [
    0.20114891231060028,
    -0.4934055507183075,
    0.7045236229896545
  ],
  "landmark_num": 105,
  "landmark": [
    290.78765869140625,
    549.17578125,
    -0.00849494431167841
  ],
  "errno": 0,
  "request_id": "e54be58b-1190-42bf-9abe-ebbb2bc9eabb"
}

```
字段说明，见 [人脸属性识别API调用说明](https://help.aliyun.com/knowledge_detail/53520.html)

## License

MIT