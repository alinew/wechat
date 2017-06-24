# 网页开发

- [JS-SDK](#JS-SDK)
- [网页授权](#网页授权)

## JS-SDK

官方文档：https://work.weixin.qq.com/api/doc#10029

```php
/**
 * JS接口临时票据
 */
$work->getJsApiTicket();

/**
 * 签名
 */
$work->jsSign();
```

## 网页授权

官方文档：https://work.weixin.qq.com/api/doc#10028

源码：[pithyone\wechat\Request\OAuth](/src/Request/OAuth.php)

```php
/**
 * 根据code获取成员信息
 */
$work->api('OAuth')->getUserInfo($code);

/**
 * 使用user_ticket获取成员详情
 */
$work->api('OAuth')->getUserDetail($user_ticket);
```