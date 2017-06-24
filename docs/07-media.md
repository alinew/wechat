# 素材管理

源码：[pithyone\wechat\Request\Media](/src/Request/Media.php)

```php
/**
 * 上传临时素材文件
 *
 * 媒体文件类型，分别有图片（image）、语音（voice）、视频（video），普通文件(file)
 *
 * 参考：https://work.weixin.qq.com/api/doc#10112
 */
$work->api('Media')->upload('image', ['media' => 'path/to/media']);

/**
 * 获取临时素材文件
 */
$media = $work->api('Media')->get($media_id);

// 下载操作
file_put_contents('save/path/to/media', $media);
```