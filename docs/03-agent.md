# 应用管理

官方文档：https://work.weixin.qq.com/api/doc#10025

源码：[pithyone\wechat\Request\Agent](/src/Request/Agent.php)

```php
/**
 * 获取应用
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10087
 */
$work->api('Agent')->get($agent_id);

/**
 * 设置应用
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10088
 */
$work->api('Agent')->set($data);

/**
 * 获取应用概况列表
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#11214
 */
$work->api('Agent')->lists();
```