<?php

namespace pithyone\wechat\Tests\Request;

use pithyone\wechat\Request\Tag;
use pithyone\wechat\Tests\TestCase;

class TagTest extends TestCase
{
    private $tag_id = 1;

    private $data = [
        'tagid' => 1,
        'tagname' => 'UI design'
    ];

    private $user = [
        'tagid' => 1,
        'userlist' => ["user1", "user2"],
        'partylist' => [2, 4]
    ];

    public function testCreate()
    {
        $response = $this->api('Tag')->create($this->data);

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(Tag::TAG_CREATE, $response['uri']);

        $this->assertEquals($this->data, $response['options']['json']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }

    public function testUpdate()
    {
        $response = $this->api('Tag')->update($this->data);

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(Tag::TAG_UPDATE, $response['uri']);

        $this->assertEquals($this->data, $response['options']['json']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }

    public function testDelete()
    {
        $response = $this->api('Tag')->delete($this->tag_id);

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(Tag::TAG_DELETE, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token, 'tagid' => $this->tag_id], $response['options']['query']);
    }

    public function testGet()
    {
        $response = $this->api('Tag')->get($this->tag_id);

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(Tag::TAG_GET, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token, 'tagid' => $this->tag_id], $response['options']['query']);
    }

    public function testAddUsers()
    {
        $response = $this->api('Tag')->addUsers($this->user);

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(Tag::TAG_ADD_USER, $response['uri']);

        $this->assertEquals($this->user, $response['options']['json']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }

    public function testDelUsers()
    {
        $response = $this->api('Tag')->delUsers($this->user);

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(Tag::TAG_DEL_USER, $response['uri']);

        $this->assertEquals($this->user, $response['options']['json']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }

    public function testLists()
    {
        $response = $this->api('Tag')->lists();

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(Tag::TAG_LIST, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }
}