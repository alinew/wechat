<?php

namespace pithyone\wechat\Tests\Request;

use pithyone\wechat\Request\Message;
use pithyone\wechat\Tests\TestCase;

class MessageTest extends TestCase
{
    private $receiver = [
        'touser' => 'touser|touser2',
        'toparty' => 'toparty|toparty2',
        'totag' => 'totag|totag2',
        'agentid' => 1
    ];

    private $content = 'content';

    private $media_id = 'media_id';

    private $title = 'title';

    private $description = 'description';

    private $url = 'url';

    private $btn_txt = '按钮文字';

    private $single_news = [
        "title" => "Title",
        "description" => "Description",
        "url" => "http://www.soso.com/",
        "picurl" => "http://shp.qpic.cn/bizmp/n42wyDus3u6UbeIZ4ouC3MSn5LudcC5WMjnoH4DEibPfia9gCzndhmgQ/"
    ];

    private $multi_news = [
        [
            "title" => "Title",
            "description" => "Description",
            "url" => "http://www.soso.com/",
            "picurl" => "http://shp.qpic.cn/bizmp/n42wyDus3u6UbeIZ4ouC3MSn5LudcC5WMjnoH4DEibPfia9gCzndhmgQ/"
        ],
        [
            "title" => "Title",
            "description" => "Description",
            "url" => "http://www.soso.com/",
            "picurl" => "http://shp.qpic.cn/bizmp/n42wyDus3u6UbeIZ4ouC3MSn5LudcC5WMjnoH4DEibPfia9gCzndhmgQ/"
        ]
    ];

    private $single_mp_news = [
        'title' => 'Title01',
        'thumb_media_id' => '2WhfwMXkZXHHHCraOs_g2z3jthiE7HG5cmcjkQc8LOTpXwyzaYhjK_VOZ6sMipKNIS5sEOHRujrzbsYVMFq3K0A',
        'author' => 'zs',
        'content_source_url' => '',
        'content' => 'Content001',
        'digest' => 'airticle01'
    ];

    private $multi_mp_news = [
        [
            'title' => 'Title01',
            'thumb_media_id' => '2WhfwMXkZXHHHCraOs_g2z3jthiE7HG5cmcjkQc8LOTpXwyzaYhjK_VOZ6sMipKNIS5sEOHRujrzbsYVMFq3K0A',
            'author' => 'zs',
            'content_source_url' => '',
            'content' => 'Content001',
            'digest' => 'airticle01'
        ],
        [
            'title' => 'Title02',
            'thumb_media_id' => '2WhfwMXkZXHHHCraOs_g2z3jthiE7HG5cmcjkQc8LOTpXwyzaYhjK_VOZ6sMipKNIS5sEOHRujrzbsYVMFq3K0A',
            'author' => 'Author001',
            'content_source_url' => '',
            'content' => 'Content002',
            'digest' => 'article02'
        ]
    ];

    public function testSetReceiver()
    {
        $message = $this->api('Message')->setReceiver($this->receiver);

        $this->assertEquals($this->receiver, $message->receiver);
    }

    public function getTextData()
    {
        return ['msgtype' => 'text', 'text' => ['content' => $this->content]];
    }

    public function testSetText()
    {
        $message = $this->api('Message')->setText($this->content);

        $this->assertEquals($this->getTextData(), $message->patch);
    }

    public function getImageData()
    {
        return ['msgtype' => 'image', 'image' => ['media_id' => $this->media_id]];
    }

    public function testSetImage()
    {
        $message = $this->api('Message')->setImage($this->media_id);

        $this->assertEquals($this->getImageData(), $message->patch);
    }

    public function getVoiceData()
    {
        return ['msgtype' => 'voice', 'voice' => ['media_id' => $this->media_id]];
    }

    public function testSetVoice()
    {
        $message = $this->api('Message')->setVoice($this->media_id);

        $this->assertEquals($this->getVoiceData(), $message->patch);
    }

    public function getVideoData()
    {
        return ['msgtype' => 'video', 'video' => ['media_id' => $this->media_id, 'title' => $this->title, 'description' => $this->description]];
    }

    public function getVideoSingleData()
    {
        return ['msgtype' => 'video', 'video' => ['media_id' => $this->media_id]];
    }

    public function testSetVideo()
    {
        $message = $this->api('Message')->setVideo($this->media_id, $this->title, $this->description);

        $this->assertEquals($this->getVideoData(), $message->patch);

        $message = $this->api('Message')->setVideo($this->media_id);

        $this->assertEquals($this->getVideoSingleData(), $message->patch);
    }

    public function getFileData()
    {
        return ['msgtype' => 'file', 'file' => ['media_id' => $this->media_id]];
    }

    public function testSetFile()
    {
        $message = $this->api('Message')->setFile($this->media_id);

        $this->assertEquals($this->getFileData(), $message->patch);
    }

    public function getTextCardDefaultData()
    {
        return [
            'msgtype' => 'textcard',
            'textcard' => [
                'title' => $this->title,
                'description' => $this->description,
                'url' => $this->url,
                'btntxt' => '详情'
            ]
        ];
    }

    public function getTextCardCustomData()
    {
        return [
            'msgtype' => 'textcard',
            'textcard' => [
                'title' => $this->title,
                'description' => $this->description,
                'url' => $this->url,
                'btntxt' => $this->btn_txt
            ]
        ];
    }

    public function testSetTextCard()
    {
        $message = $this->api('Message')->setTextCard($this->title, $this->description, $this->url);

        $this->assertEquals($this->getTextCardDefaultData(), $message->patch);

        $message = $this->api('Message')->setTextCard($this->title, $this->description, $this->url, $this->btn_txt);

        $this->assertEquals($this->getTextCardCustomData(), $message->patch);
    }

    public function getSingleNewsData()
    {
        return ['msgtype' => 'news', 'news' => ['articles' => [$this->single_news]]];
    }

    public function getMultiNewsData()
    {
        return ['msgtype' => 'news', 'news' => ['articles' => $this->multi_news]];
    }

    public function testSetNews()
    {
        $message = $this->api('Message')->setNews($this->single_news);

        $this->assertEquals($this->getSingleNewsData(), $message->patch);

        $message = $this->api('Message')->setNews($this->multi_news);

        $this->assertEquals($this->getMultiNewsData(), $message->patch);
    }

    public function getSingleMpNewsData()
    {
        return ['msgtype' => 'mpnews', 'mpnews' => ['articles' => [$this->single_mp_news]]];
    }

    public function getMultiMpNewsData()
    {
        return ['msgtype' => 'mpnews', 'mpnews' => ['articles' => $this->multi_mp_news]];
    }

    public function testSetMpNews()
    {
        $message = $this->api('Message')->setMpNews($this->single_mp_news);

        $this->assertEquals($this->getSingleMpNewsData(), $message->patch);

        $message = $this->api('Message')->setMpNews($this->multi_mp_news);

        $this->assertEquals($this->getMultiMpNewsData(), $message->patch);
    }

    public function getData($data)
    {
        return array_merge($this->receiver, $data);
    }

    public function testSend()
    {
        $response = $this->api('Message')->setReceiver($this->receiver)->setText($this->content)->send();

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(Message::MESSAGE_SEND, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);

        $this->assertEquals($this->getData($this->getTextData()), $response['options']['json']);

        $response = $this->api('Message')->setReceiver($this->receiver)->setImage($this->media_id)->send();

        $this->assertEquals($this->getData($this->getImageData()), $response['options']['json']);

        $response = $this->api('Message')->setReceiver($this->receiver)->setVoice($this->media_id)->send();

        $this->assertEquals($this->getData($this->getVoiceData()), $response['options']['json']);

        $response = $this->api('Message')->setReceiver($this->receiver)->setVideo($this->media_id)->send();

        $this->assertEquals($this->getData($this->getVideoSingleData()), $response['options']['json']);

        $response = $this->api('Message')->setReceiver($this->receiver)->setVideo($this->media_id, $this->title, $this->description)->send();

        $this->assertEquals($this->getData($this->getVideoData()), $response['options']['json']);

        $response = $this->api('Message')->setReceiver($this->receiver)->setFile($this->media_id)->send();

        $this->assertEquals($this->getData($this->getFileData()), $response['options']['json']);

        $response = $this->api('Message')->setReceiver($this->receiver)->setTextCard($this->title, $this->description, $this->url)->send();

        $this->assertEquals($this->getData($this->getTextCardDefaultData()), $response['options']['json']);

        $response = $this->api('Message')->setReceiver($this->receiver)->setTextCard($this->title, $this->description, $this->url, $this->btn_txt)->send();

        $this->assertEquals($this->getData($this->getTextCardCustomData()), $response['options']['json']);

        $response = $this->api('Message')->setReceiver($this->receiver)->setNews($this->single_news)->send();

        $this->assertEquals($this->getData($this->getSingleNewsData()), $response['options']['json']);

        $response = $this->api('Message')->setReceiver($this->receiver)->setNews($this->multi_news)->send();

        $this->assertEquals($this->getData($this->getMultiNewsData()), $response['options']['json']);

        $response = $this->api('Message')->setReceiver($this->receiver)->setMpNews($this->single_mp_news)->send();

        $this->assertEquals($this->getData($this->getSingleMpNewsData()), $response['options']['json']);

        $response = $this->api('Message')->setReceiver($this->receiver)->setMpNews($this->multi_mp_news)->send();

        $this->assertEquals($this->getData($this->getMultiMpNewsData()), $response['options']['json']);
    }
}