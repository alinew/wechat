<?php

namespace pithyone\wechat\Push;

use LSS\Array2XML;
use pithyone\wechat\crypt\Message;
use pithyone\wechat\crypt\PrpCrypt;

trait Reply
{
    /**
     * @return string
     */
    abstract protected function getFromUserName();

    /**
     * @return string
     */
    abstract protected function getToUserName();

    /**
     * @return Message
     */
    abstract protected function getMessage();

    /**
     * @return string
     */
    abstract protected function getAesKey();

    /**
     * 文本消息
     * @param string $content 文本消息内容
     * @return string
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function text($content)
    {
        $node = [
            'MsgType' => ['@cdata' => 'text'],
            'Content' => ['@cdata' => $content]
        ];

        return $this->encrypt($node);
    }

    /**
     * 图片消息
     * @param string $media_id 图片媒体文件id，可以调用获取媒体文件接口拉取
     * @return string
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function image($media_id)
    {
        $node = [
            'MsgType' => ['@cdata' => 'image'],
            'Image' => [
                'MediaId' => ['@cdata' => $media_id]
            ]
        ];

        return $this->encrypt($node);
    }

    /**
     * 语音消息
     * @param string $media_id 语音文件id，可以调用获取媒体文件接口拉取
     * @return string
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function voice($media_id)
    {
        $node = [
            'MsgType' => ['@cdata' => 'voice'],
            'Voice' => [
                'MediaId' => ['@cdata' => $media_id]
            ]
        ];

        return $this->encrypt($node);
    }

    /**
     * 视频消息
     * @param string $media_id 视频文件id，可以调用获取媒体文件接口拉取
     * @param string $title 视频消息的标题
     * @param string $description 视频消息的描述
     * @return string
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function video($media_id, $title, $description)
    {
        $node = [
            'MsgType' => ['@cdata' => 'video'],
            'Video' => [
                'MediaId' => ['@cdata' => $media_id],
                'Title' => ['@cdata' => $title],
                'Description' => ['@cdata' => $description]
            ]
        ];

        return $this->encrypt($node);
    }

    /**
     * 图文消息
     * @param array $articles
     * @return string
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function news($articles)
    {
        $node = [
            'MsgType' => ['@cdata' => 'news'],
            'ArticleCount' => count($articles),
            'Articles' => [
                [
                    'item' => $this->articlesConvert($articles)
                ]
            ]
        ];

        return $this->encrypt($node);
    }

    /**
     * @param array $articles
     * @return array
     * @author wangbing <pithyone@vip.qq.com>
     */
    private function articlesConvert($articles)
    {
        $articles = count($articles) == count($articles, 1) ? [$articles] : $articles;

        foreach ($articles as &$article) {
            foreach ($article as $key => $value) {
                $article[$key] = ['@cdata' => $value];
            }
        }

        return $articles;
    }

    /**
     * 被动响应消息
     * @param array $patch
     * @return string
     * @author wangbing <pithyone@vip.qq.com>
     */
    protected function encrypt($patch)
    {
        $timestamp = time();

        $array = [
            'ToUserName' => ['@cdata' => $this->getToUserName()],
            'FromUserName' => ['@cdata' => $this->getFromUserName()],
            'CreateTime' => $timestamp
        ];

        $array = array_merge($array, $patch);

        $xml = Array2XML::createXML('xml', $array);
        $reply_xml = $xml->saveXML($xml->firstChild);

        $encrypt_message = '';

        $this->getMessage()->encrypt($reply_xml, $timestamp, $this->getNonce(), $encrypt_message);

        return $encrypt_message;
    }

    /**
     * @return string
     * @author wangbing <pithyone@vip.qq.com>
     */
    private function getNonce()
    {
        $prpCrypt = new PrpCrypt($this->getAesKey());
        return $prpCrypt->getRandomStr();
    }
}