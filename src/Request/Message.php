<?php

namespace pithyone\wechat\Request;

class Message extends Api
{
    const MESSAGE_SEND = 'message/send';

    /**
     * @var array
     */
    public $receiver;

    /**
     * @var array
     */
    public $patch;

    /**
     * @var array
     */
    public $data;

    /**
     * 发消息
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function send()
    {
        $this->data = array_merge($this->receiver, $this->patch);

        return $this->request('post', self::MESSAGE_SEND, $this->data);
    }

    /**
     * @param $receiver
     * @return $this
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * 文本消息
     * @param string $content 消息内容，最长不超过2048个字节
     * @return $this
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function setText($content)
    {
        $this->patch = [
            'msgtype' => 'text',
            'text' => ['content' => $content]
        ];

        return $this;
    }

    /**
     * 图片消息
     * @param string $media_id 图片媒体文件id，可以调用上传临时素材接口获取
     * @return $this
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function setImage($media_id)
    {
        $this->patch = [
            'msgtype' => 'image',
            'image' => ['media_id' => $media_id]
        ];

        return $this;
    }

    /**
     * 语音消息
     * @param string $media_id 语音文件id，可以调用上传临时素材接口获取
     * @return $this
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function setVoice($media_id)
    {
        $this->patch = [
            'msgtype' => 'voice',
            'voice' => ['media_id' => $media_id]
        ];

        return $this;
    }

    /**
     * 视频消息
     * @param string $media_id 视频媒体文件id，可以调用上传临时素材接口获取
     * @param string $title 视频消息的标题，不超过128个字节，超过会自动截断
     * @param string $description 视频消息的描述，不超过512个字节，超过会自动截断
     * @return $this
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function setVideo($media_id, $title = '', $description = '')
    {
        $video = ['media_id' => $media_id];
        $title && $video['title'] = $title;
        $description && $video['description'] = $description;

        $this->patch = [
            'msgtype' => 'video',
            'video' => $video
        ];

        return $this;
    }

    /**
     * 文件消息
     * @param string $media_id 文件id，可以调用上传临时素材接口获取
     * @return $this
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function setFile($media_id)
    {
        $this->patch = [
            'msgtype' => 'file',
            'file' => ['media_id' => $media_id]
        ];

        return $this;
    }

    /**
     * 文本卡片消息
     * @param string $title 标题，不超过128个字节，超过会自动截断
     * @param string $description 描述，不超过512个字节，超过会自动截断
     * @param string $url 点击后跳转的链接。
     * @param string $btn_txt 按钮文字。 默认为“详情”， 不超过4个文字，超过自动截断。
     * @return $this
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function setTextCard($title, $description, $url, $btn_txt = '详情')
    {
        $this->patch = [
            'msgtype' => 'textcard',
            'textcard' => [
                'title' => $title,
                'description' => $description,
                'url' => $url,
                'btntxt' => $btn_txt
            ]
        ];

        return $this;
    }

    /**
     * 图文消息
     * @param array $articles 图文消息，一个图文消息支持1到8条图文
     * @return $this
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function setNews($articles)
    {
        $this->patch = [
            'msgtype' => 'news',
            'news' => [
                'articles' => count($articles) == count($articles, 1) ? [$articles] : $articles
            ]
        ];

        return $this;
    }

    /**
     * 图文消息（mpnews）
     * @param array $articles 图文消息，一个图文消息支持1到8条图文
     * @return $this
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function setMpNews($articles)
    {
        $this->patch = [
            'msgtype' => 'mpnews',
            'mpnews' => [
                'articles' => count($articles) == count($articles, 1) ? [$articles] : $articles
            ]
        ];

        return $this;
    }
}