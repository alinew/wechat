# PHP Work WeChat

[企业微信](https://work.weixin.qq.com) API

## 目录
- [介绍](#介绍)
- [环境要求](#环境要求)
- [安装](#安装)
- [用法](#用法)
    - [初始化](#初始化)
    - [获取access_token](docs/01-access-token.md)
    - [通讯录](docs/02-contacts.md)
    - [应用管理](docs/03-agent.md)
    - [消息推送](docs/04-message-push.md)
    - [网页开发](docs/05-html.md)
    - [自定义菜单](docs/06-menu.md)
    - [素材管理](docs/07-media.md)

## 介绍

[企业微信](https://work.weixin.qq.com)提供了通讯录同步、应用管理、消息推送、OAuth2用户身份识别、JS-SDK等[API](http://work.weixin.qq.com/api/doc)，为企业接入更多个性化的办公应用。

## 环境要求

- PHP >= 5.5.0

## 安装

使用 [composer](http://getcomposer.org/):

```shell
composer require pithyone/wechat
```

## 用法

### 初始化

#### 缓存

本 SDK 不提供缓存方法，你必须自己定义缓存类，通过实现接口：[pithyone\wechat\CacheInterface](src/CacheInterface.php)

#### 日志

本 SDK 不提供记录日志方法，你必须自己定义日志类，通过实现接口：[Psr\Log\LoggerInterface](https://github.com/php-fig/log/blob/master/Psr/Log/LoggerInterface.php)

#### 完整配置

```php
$config = [
    // 是否写入日志
    'debug' => true,

    // 企业唯一corpid
    'corp_id' => 'your_corp_id',

    // 企业每一个应用都有一个独立的secret
    'secret' => 'your_agent_secret',

    // 可任意填写，用于生成签名
    'token' => 'your_token',

    // 用于消息体的加密，是AES密钥的Base64编码
    'aes_key' => 'your_aes_key',

    // 缓存类
    'cache' => $your_cache_class,

    // 日志类
    'logger' => $your_log_class,

    // Guzzle配置，参考： http://docs.guzzlephp.org/en/latest/request-options.html
    'guzzle' => [
        'timeout' => 5.0
    ]
];
```

#### 获取实例

```php
$work = new \pithyone\wechat\Work($config);
```
