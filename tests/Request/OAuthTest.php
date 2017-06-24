<?php

namespace pithyone\wechat\Tests\Request;

use pithyone\wechat\Request\OAuth;
use pithyone\wechat\Tests\TestCase;

class OAuthTest extends TestCase
{
    public function testGetUserInfo()
    {
        $code = 'code';

        $response = $this->api('OAuth')->getUserInfo($code);

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(OAuth::USER_GET_USER_INFO, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token, 'code' => $code], $response['options']['query']);
    }

    public function testGetUserDetail()
    {
        $user_ticket = 'user_ticket';

        $response = $this->api('OAuth')->getUserDetail($user_ticket);

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(OAuth::USER_GET_USER_DETAIL, $response['uri']);

        $this->assertEquals(['user_ticket' => $user_ticket], $response['options']['json']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }
}