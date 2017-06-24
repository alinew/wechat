<?php

namespace pithyone\wechat\Tests\Request;

use pithyone\wechat\Request\Batch;
use pithyone\wechat\Tests\TestCase;

class BatchTest extends TestCase
{
    private $data = [
        'media_id' => 'xxxxxx',
        'callback' =>
            [
                'url' => 'xxx',
                'token' => 'xxx',
                'encodingaeskey' => 'xxx'
            ]
    ];

    public function testSyncUser()
    {
        $response = $this->api('Batch')->syncUser($this->data);

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(Batch::BATCH_SYNC_USER, $response['uri']);

        $this->assertEquals($this->data, $response['options']['json']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }

    public function testReplaceUser()
    {
        $response = $this->api('Batch')->replaceUser($this->data);

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(Batch::BATCH_REPLACE_USER, $response['uri']);

        $this->assertEquals($this->data, $response['options']['json']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }

    public function testReplaceParty()
    {
        $response = $this->api('Batch')->replaceParty($this->data);

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(Batch::BATCH_REPLACE_PARTY, $response['uri']);

        $this->assertEquals($this->data, $response['options']['json']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }

    public function testResult()
    {
        $job_id = 1;

        $response = $this->api('Batch')->result($job_id);

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(Batch::BATCH_GET_RESULT, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token, 'jobid' => $job_id], $response['options']['query']);
    }
}