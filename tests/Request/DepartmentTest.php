<?php

namespace pithyone\wechat\Tests\Request;

use pithyone\wechat\Request\Department;
use pithyone\wechat\Tests\TestCase;

class DepartmentTest extends TestCase
{
    private $data = [
        'name' => '广州研发中心',
        'parentid' => 1,
        'order' => 1,
        'id' => 1,
    ];

    private $id = 1;

    public function testCreate()
    {
        $response = $this->api('Department')->create($this->data);

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(Department::DEPARTMENT_CREATE, $response['uri']);

        $this->assertEquals($this->data, $response['options']['json']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }

    public function testUpdate()
    {
        $response = $this->api('Department')->update($this->data);

        $this->assertEquals('POST', $response['method']);

        $this->assertEquals(Department::DEPARTMENT_UPDATE, $response['uri']);

        $this->assertEquals($this->data, $response['options']['json']);

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }

    public function testDelete()
    {
        $response = $this->api('Department')->delete($this->id);

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(Department::DEPARTMENT_DELETE, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token, 'id' => $this->id], $response['options']['query']);
    }

    public function testLists()
    {
        $response = $this->api('Department')->lists($this->id);

        $this->assertEquals('GET', $response['method']);

        $this->assertEquals(Department::DEPARTMENT_LIST, $response['uri']);

        $this->assertEquals(['access_token' => $this->access_token, 'id' => $this->id], $response['options']['query']);

        $response = $this->api('Department')->lists();

        $this->assertEquals(['access_token' => $this->access_token], $response['options']['query']);
    }
}