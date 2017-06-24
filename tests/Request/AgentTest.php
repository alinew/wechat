<?php

namespace pithyone\wechat\Tests\Request;

use pithyone\wechat\Request\Agent;
use pithyone\wechat\Tests\TestCase;

class AgentTest extends TestCase
{
    public $agent_id = 1;

    public function testGet()
    {
        $response = $this->api('Agent')->get($this->agent_id);

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(Agent::AGENT_GET, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token, 'agentid' => $this->agent_id], $response['options']['query']);
    }

    public function testSet()
    {
        $data = [
            'agentid' => '5',
            'report_location_flag' => '0',
            'logo_mediaid' => 'xxxxx',
            'name' => 'NAME',
            'description' => 'DESC',
            'redirect_domain' => 'xxxxxx',
            'isreportenter' => 0,
            'home_url' => 'http://www.qq.com'
        ];

        $response = $this->api('Agent')->set($data);

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(Agent::AGENT_SET, $response['uri']);

        $this->assertEquals($data, $response['options']['json']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }

    public function testLists()
    {
        $response = $this->api('Agent')->lists();

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(Agent::AGENT_LIST, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }
}