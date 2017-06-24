<?php

namespace pithyone\wechat\Tests\Request;

use pithyone\wechat\Request\User;
use pithyone\wechat\Tests\TestCase;

class UserTest extends TestCase
{
    private $data = [
        'userid' => 'zhangsan',
        'name' => '张三',
        'department' => [1, 2],
        'position' => '后台工程师',
        'mobile' => '15913215421',
        'gender' => '1',
        'email' => 'zhangsan@gzdev.com',
        'weixinid' => 'lisifordev',
        'enable' => 1,
        'avatar_mediaid' => '2WhfwMXkZXHHHCraOs_g2z3jthiE7HG5cmcjkQc8LOTpXwyzaYhjK_VOZ6sMipKNIS5sEOHRujrzbsYVMFq3K0A',
        'extattr' =>
            [
                'attrs' =>
                    [
                        [
                            'name' => '爱好',
                            'value' => '旅游',
                        ],
                        [
                            'name' => '卡号',
                            'value' => '1234567234',
                        ]
                    ]
            ]
    ];

    private $user_id = 'zhangsan';

    private $user_id_list = ["zhangsan", "lisi"];

    private $department_id = 1;

    private $fetch_child = 0;

    public function testCreate()
    {
        $response = $this->api('User')->create($this->data);

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(User::USER_CREATE, $response['uri']);

        $this->assertEquals($this->data, $response['options']['json']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }

    public function testUpdate()
    {
        $response = $this->api('User')->update($this->data);

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(User::USER_UPDATE, $response['uri']);

        $this->assertEquals($this->data, $response['options']['json']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }

    public function testDelete()
    {
        $response = $this->api('User')->delete($this->user_id);

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(User::USER_DELETE, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token, 'userid' => $this->user_id], $response['options']['query']);
    }

    public function testBatchDelete()
    {
        $response = $this->api('User')->batchDelete($this->user_id_list);

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(User::USER_BATCH_DELETE, $response['uri']);

        $this->assertEquals(['useridlist' => $this->user_id_list], $response['options']['json']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }

    public function testGet()
    {
        $response = $this->api('User')->get($this->user_id);

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(User::USER_GET, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token, 'userid' => $this->user_id], $response['options']['query']);
    }

    public function testSimpleLists()
    {
        $response = $this->api('User')->simpleLists($this->department_id);

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(User::USER_SIMPLE_LIST, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token, 'department_id' => $this->department_id, 'fetch_child' => 0], $response['options']['query']);

        $response = $this->api('User')->simpleLists($this->department_id, $this->fetch_child);

        $this->assertEquals(['access_token' => $this->access_token, 'department_id' => $this->department_id, 'fetch_child' => $this->fetch_child], $response['options']['query']);
    }

    public function testLists()
    {
        $response = $this->api('User')->lists($this->department_id);

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(User::USER_LIST, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token, 'department_id' => $this->department_id, 'fetch_child' => 0], $response['options']['query']);

        $response = $this->api('User')->lists($this->department_id, $this->fetch_child);

        $this->assertEquals(['access_token' => $this->access_token, 'department_id' => $this->department_id, 'fetch_child' => $this->fetch_child], $response['options']['query']);
    }
}