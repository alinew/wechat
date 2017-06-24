<?php

namespace pithyone\wechat\Tests\Request;

use pithyone\wechat\Request\IP;
use pithyone\wechat\Tests\TestCase;

class IPTest extends TestCase
{
    public function testGetCallbackIP()
    {
        $response = $this->api('IP')->getCallbackIP();

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(IP::GET_CALLBACK_IP, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }
}