<?php

namespace pithyone\wechat\Tests\Request;

use pithyone\wechat\Request\Menu;
use pithyone\wechat\Tests\TestCase;

class MenuTest extends TestCase
{
    private $data = [
        'button' =>
            [
                [
                    'name' => '扫码',
                    'sub_button' =>
                        [
                            [
                                'type' => 'scancode_waitmsg',
                                'name' => '扫码带提示',
                                'key' => 'rselfmenu_0_0',
                                'sub_button' => []
                            ],
                            [
                                'type' => 'scancode_push',
                                'name' => '扫码推事件',
                                'key' => 'rselfmenu_0_1',
                                'sub_button' => []
                            ]
                        ]
                ],
                [
                    'name' => '发图',
                    'sub_button' =>
                        [

                            [
                                'type' => 'pic_sysphoto',
                                'name' => '系统拍照发图',
                                'key' => 'rselfmenu_1_0',
                                'sub_button' => []
                            ],
                            [
                                'type' => 'pic_photo_or_album',
                                'name' => '拍照或者相册发图',
                                'key' => 'rselfmenu_1_1',
                                'sub_button' => []
                            ],
                            [
                                'type' => 'pic_weixin',
                                'name' => '微信相册发图',
                                'key' => 'rselfmenu_1_2',
                                'sub_button' => []
                            ]
                        ]
                ],
                [
                    'name' => '其他',
                    'sub_button' =>
                        [
                            [
                                'type' => 'view',
                                'name' => '搜索',
                                'url' => 'http://www.soso.com/',
                            ],
                            [
                                'type' => 'click',
                                'name' => '赞一下我们',
                                'key' => 'V1001_GOOD',
                            ],
                            [
                                'name' => '发送位置',
                                'type' => 'location_select',
                                'key' => 'rselfmenu_2_0',
                            ]
                        ]
                ]
            ]
    ];

    private $agent_id = 1;

    public function testCreate()
    {
        $response = $this->api('Menu')->create($this->agent_id, $this->data);

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(Menu::MENU_CREATE, $response['uri']);

        $this->assertEquals($this->data, $response['options']['json']);

        $this->assertEquals(['access_token' => $this->access_token, 'agentid' => $this->agent_id], $response['options']['query']);
    }

    public function testDelete()
    {
        $response = $this->api('Menu')->delete($this->agent_id);

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(Menu::MENU_DELETE, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token, 'agentid' => $this->agent_id], $response['options']['query']);
    }

    public function testGet()
    {
        $response = $this->api('Menu')->get($this->agent_id);

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(Menu::MENU_GET, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token, 'agentid' => $this->agent_id], $response['options']['query']);
    }
}