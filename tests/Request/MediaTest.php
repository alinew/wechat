<?php

namespace pithyone\wechat\Tests\Request;

use pithyone\wechat\Request\Media;
use pithyone\wechat\Tests\TestCase;

class MediaTest extends TestCase
{
    private $file = 'path/to/file';

    public function testUpload()
    {
        $type = 'type';

        $response = $this->api('Media')->upload($type, ['media' => $this->file]);

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(Media::MEDIA_UPLOAD, $response['uri']);

        $this->assertEquals([['name' => 'media', 'contents' => $this->file]], $response['options']['multipart']);

        $this->assertEquals(['access_token' => $this->access_token, 'type' => $type], $response['options']['query']);
    }

    public function testGet()
    {
        $media_id = 'media_id';

        $response = $this->api('Media')->get($media_id);

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(Media::MEDIA_GET, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token, 'media_id' => $media_id], $response['options']['query']);
    }
}