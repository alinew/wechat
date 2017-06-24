# 通讯录

官方文档：https://work.weixin.qq.com/api/doc#10016

- [成员管理](#成员管理)
- [部门管理](#部门管理)
- [异步任务接口](#异步任务接口)
- [标签管理](#标签管理)

## 成员管理

源码：[pithyone\wechat\Request\User](/src/Request/User.php)

```php
/**
 * 创建成员
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10018
 */
$work->api('User')->create($data);

/**
 * 读取成员
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10019
 */
$work->api('User')->get('zhangsan');

/**
 * 更新成员
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10020
 */
$work->api('User')->update($data);

/**
 * 删除成员
 */
$work->api('User')->delete('zhangsan');

/**
 * 批量删除成员
 */
$work->api('User')->batchDelete(['zhangsan']);

/**
 * 获取部门成员
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10061
 */
$work->api('User')->simpleLists($department_id, $fetch_child);

/**
 * 获取部门成员详情
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10063
 */
$work->api('User')->lists($department_id, $fetch_child);
```

## 部门管理

源码：[pithyone\wechat\Request\Department](/src/Request/Department.php)

```php
/**
 * 创建部门
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10076
 */
$work->api('Department')->create($data);

/**
 * 更新部门
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10077
 */
$work->api('Department')->update($data);

/**
 * 删除部门
 */
$work->api('Department')->delete($id);

/**
 * 获取部门列表
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10093
 */
$work->api('Department')->lists($id);
```

## 异步任务接口

源码：[pithyone\wechat\Request\Batch](/src/Request/Batch.php)

```php
/**
 * 增量更新成员
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10138
 */
$work->api('Batch')->syncUser($data);

/**
 * 全量覆盖成员
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10138
 */
$work->api('Batch')->replaceUser($data);

/**
 * 全量覆盖部门
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10138
 */
$work->api('Batch')->replaceParty($data);

/**
 * 获取异步任务结果
 */
$work->api('Batch')->result($job_id);
```

## 标签管理

源码：[pithyone\wechat\Request\Tag](/src/Request/Tag.php)

```php
/**
 * 创建标签
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10915
 */
$work->api('Tag')->create($data);

/**
 * 更新标签名字
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10919
 */
$work->api('Tag')->update($data);

/**
 * 删除标签
 */
$work->api('Tag')->delete($tag_id);

/**
 * 获取标签成员
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10921
 */
$work->api('Tag')->get($tag_id);

/**
 * 增加标签成员
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10923
 */
$work->api('Tag')->addUsers($user);

/**
 * 删除标签成员
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10925
 */
$work->api('Tag')->delUsers($user);

/**
 * 获取标签列表
 *
 * 数据结构，参考：https://work.weixin.qq.com/api/doc#10926
 */
$work->api('Tag')->lists();
```