# 消息推送

- [发送消息](#发送消息)
- [接收消息并回复](#接收消息并回复)

## 发送消息

官方文档：https://work.weixin.qq.com/api/doc#10167

源码：[pithyone\wechat\Request\Message](/src/Request/Message.php)

```php
/**
 * 文本消息
 */
$work->api('Message')->setReceiver($receiver)->setText('文本消息')->send();

/**
 * 图片消息
 */
$work->api('Message')->setReceiver($receiver)->setImage($media_id)->send();

/**
 * 语音消息
 */
$work->api('Message')->setReceiver($receiver)->setVoice($media_id)->send();

/**
 * 视频消息
 */
$work->api('Message')->setReceiver($receiver)->setVideo($media_id, $title, $description)->send();

/**
 * 文件消息
 */
$work->api('Message')->setReceiver($receiver)->setFile($media_id)->send();

// 标题，不超过128个字节，超过会自动截断
$title = "领奖通知";

// 描述，不超过512个字节，超过会自动截断
$description = "<div class=\"gray\">2016年9月26日</div> <div class=\"normal\">恭喜你抽中iPhone 7一台，领奖码：xxxx</div><div class=\"highlight\">请于2016年10月10日前联系行政同事领取</div>";

// 点击后跳转的链接
$url = "http://www.soso.com";

// 按钮文字。 默认为“详情”， 不超过4个文字，超过自动截断
$btn_txt = "按钮文字";

/**
 * 文本卡片消息
 *
 * 卡片消息的展现形式非常灵活，支持使用br标签或者空格来进行换行处理，也支持使用div标签来使用不同的字体颜色，目前内置了3种文字颜色：灰色(gray)、高亮(highlight)、默认黑色(normal)，将其作为div标签的class属性即可
 */
$work->api('Message')->setReceiver($receiver)->setTextCard($title, $description, $url)->send();
$work->api('Message')->setReceiver($receiver)->setTextCard($title, $description, $url, $btn_txt)->send();

// 单图文消息
$data = [
    "title" => "中秋节礼品领取",
    "description" => "今年中秋节公司有豪礼相送",
    "url" => "URL",
    "picurl" => "http://res.mail.qq.com/node/ww/wwopenmng/images/independent/doc/test_pic_msg1.png"
];

// 多图文消息，一个图文消息支持1到8条图文
$data = [
    [
        "title" => "中秋节礼品领取",
        "description" => "今年中秋节公司有豪礼相送",
        "url" => "URL",
        "picurl" => "http://res.mail.qq.com/node/ww/wwopenmng/images/independent/doc/test_pic_msg1.png"
    ],
    [
        "title" => "中秋节礼品领取",
        "description" => "今年中秋节公司有豪礼相送",
        "url" => "URL",
        "picurl" => "http://res.mail.qq.com/node/ww/wwopenmng/images/independent/doc/test_pic_msg1.png"
    ]
];

/**
 * 图文消息
 */
$work->api('Message')->setReceiver($receiver)->setNews($data)->send();

// 单图文消息（mpnews）
$data = [
    'title' => 'Title',
    'thumb_media_id' => 'MEDIA_ID',
    'author' => 'Author',
    'content_source_url' => 'URL',
    'content' => 'Content',
    'digest' => 'Digest description'
];

// 多图文消息（mpnews），一个图文消息支持1到8条图文
$data = [
    [
        'title' => 'Title',
        'thumb_media_id' => 'MEDIA_ID',
        'author' => 'Author',
        'content_source_url' => 'URL',
        'content' => 'Content',
        'digest' => 'Digest description'
    ],
    [
        'title' => 'Title',
        'thumb_media_id' => 'MEDIA_ID',
        'author' => 'Author',
        'content_source_url' => 'URL',
        'content' => 'Content',
        'digest' => 'Digest description'
    ]
];

/**
 * 图文消息（mpnews）
 */
$work->api('Message')->setReceiver($receiver)->setMpNews($data)->send();
```

## 接收消息并回复

源码：

- [pithyone\wechat\Push\Receive](/src/Push/Receive.php)
- [pithyone\wechat\Push\Reply](/src/Push/Reply.php)

```php
/**
 * 接收消息
 */
$push = $work->push();

/**
 * 如携带 echostr 加密的随机字符串，应初始化接收消息服务
 *
 * 参考：https://work.weixin.qq.com/api/doc#10514
 */
if ($_GET['echostr']) {
    echo $push->decryptEchoStr;
} else {
    /**
     * 判断接收消息类型，并回复消息
     */
    switch ($push->MsgType) {
        case 'text':
            echo $push->text("text消息\nContent：{$push->Content}");
            break;
        case 'image':
            echo $push->text("image消息\nPicUrl：{$push->PicUrl}\nMediaId：{$push->MediaId}");
            break;
        case 'voice':
            echo $push->text("voice消息\nFormat：{$push->Format}\nMediaId：{$push->MediaId}");
            break;
        case 'video':
            echo $push->text("video消息\nThumbMediaId：{$push->ThumbMediaId}\nMediaId：{$push->MediaId}");
            break;
        case 'shortvideo':
            echo $push->text("小视频消息\nThumbMediaId：{$push->ThumbMediaId}\nMediaId：{$push->MediaId}");
            break;
        case 'location':
            echo $push->text("location消息\nLocation_X：{$push->Location_X}\nLocation_Y：{$push->Location_Y}\nScale：{$push->Scale}\nLabel：{$push->Label}");
            break;
        case 'link':
            echo $push->text("link消息\nTitle：{$push->Title}\nDescription：{$push->Description}\nPicUrl：{$push->PicUrl}");
            break;
        case 'event':
            switch ($push->Event) {
                case 'subscribe':
                    echo $push->text("成员关注事件");
                    break;
                case 'unsubscribe':
                    echo $push->text("成员取消关注事件");
                    break;
                case 'enter_agent':
                    echo $push->text("进入应用");
                    break;
                case 'LOCATION':
                    echo $push->text("上报地理位置\nLatitude：{$push->Latitude}\nLongitude：{$push->Longitude}\nPrecision：{$push->Precision}");
                    break;
                case 'batch_job_result':
                    echo $push->text("异步任务完成事件推送\nBatchJob：" . var_export($push->BatchJob));
                    break;
                case 'change_contact':
                    echo $push->text("通讯录变更事件\nUserID：" . $push->UserID);
                    break;
                case 'click':
                    echo $push->text("点击菜单拉取消息的事件推送\nEventKey：{$push->EventKey}");
                    break;
                case 'view':
                    echo $push->text("点击菜单跳转链接的事件推送\nEventKey：{$push->EventKey}");
                    break;
                case 'scancode_push':
                    echo $push->text("扫码推事件的事件推送\nEventKey：{$push->EventKey}\nScanCodeInfo：" . var_export($push->ScanCodeInfo));
                    break;
                case 'scancode_waitmsg':
                    echo $push->text("扫码推事件且弹出“消息接收中”提示框的事件推送\nEventKey：{$push->EventKey}\nScanCodeInfo：" . var_export($push->ScanCodeInfo));
                    break;
                case 'pic_sysphoto':
                    echo $push->text("弹出系统拍照发图的事件推送\nEventKey：{$push->EventKey}\nSendPicsInfo：" . var_export($push->SendPicsInfo));
                    break;
                case 'pic_photo_or_album':
                    echo $push->text("弹出拍照或者相册发图的事件推送\nEventKey：{$push->EventKey}\nSendPicsInfo：" . var_export($push->SendPicsInfo));
                    break;
                case 'pic_weixin':
                    echo $push->text("弹出微信相册发图器的事件推送\nEventKey：{$push->EventKey}\nSendPicsInfo：" . var_export($push->SendPicsInfo));
                    break;
                case 'location_select':
                    echo $push->text("弹出地理位置选择器的事件推送\nEventKey：{$push->EventKey}\nSendLocationInfo：" . var_export($push->SendLocationInfo));
                    break;
                default:
                    echo $push->text("敬请期待");
                    break;
            }
            break;
        default:
            echo '无法识别';
            break;
    }
}
```