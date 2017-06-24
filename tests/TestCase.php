<?php

namespace pithyone\wechat\Tests;

use pithyone\wechat\Http\Guzzle;
use pithyone\wechat\Request\Agent;
use pithyone\wechat\Request\Batch;
use pithyone\wechat\Request\Department;
use pithyone\wechat\Request\IP;
use pithyone\wechat\Request\Js;
use pithyone\wechat\Request\Media;
use pithyone\wechat\Request\Menu;
use pithyone\wechat\Request\Message;
use pithyone\wechat\Request\OAuth;
use pithyone\wechat\Request\Tag;
use pithyone\wechat\Request\Token;
use pithyone\wechat\Request\User;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    const BASE_URI = 'https://qyapi.weixin.qq.com/cgi-bin/';

    protected $access_token = 'access_token';
    protected $corp_id = 'corp_id';
    protected $secret = 'secret';

    protected $apiProvider = [
        'Agent' => Agent::class,
        'Batch' => Batch::class,
        'Department' => Department::class,
        'IP' => IP::class,
        'Js' => Js::class,
        'Media' => Media::class,
        'Menu' => Menu::class,
        'Message' => Message::class,
        'OAuth' => OAuth::class,
        'Tag' => Tag::class,
        'Token' => Token::class,
        'User' => User::class,
    ];

    protected function getHttp()
    {
        $mock = \Mockery::mock(Guzzle::class . '[request,getContents]', [self::BASE_URI]);

        $mock->shouldReceive('request')->andReturnUsing(function ($method, $uri, $options) {
            return json_encode(['method' => $method, 'uri' => $uri, 'options' => $options]);
        });

        $mock->shouldReceive('getContents')->andReturnUsing(function ($path) {
            return $path;
        });

        return $mock;
    }

    protected function api($name)
    {
        return new $this->apiProvider[$name]($this->getHttp(), $this->access_token);
    }
}