# 自定义菜单

源码：[pithyone\wechat\Request\Menu](/src/Request/Menu.php)

```php
/**
 * 创建菜单
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10786
 */
$work->api('Menu')->create($agent_id, $data);

/**
 * 获取菜单
 */
$work->api('Menu')->get($agent_id);

/**
 * 删除菜单
 */
$work->api('Menu')->delete($agent_id);
```