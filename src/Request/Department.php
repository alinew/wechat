<?php

namespace pithyone\wechat\Request;

class Department extends Api
{
    const DEPARTMENT_CREATE = 'department/create';
    const DEPARTMENT_UPDATE = 'department/update';
    const DEPARTMENT_DELETE = 'department/delete';
    const DEPARTMENT_LIST = 'department/list';

    /**
     * 创建部门
     * @param array $data
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function create($data)
    {
        return $this->request('post', self::DEPARTMENT_CREATE, $data);
    }

    /**
     * 更新部门
     * @param array $data
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function update($data)
    {
        return $this->request('post', self::DEPARTMENT_UPDATE, $data);
    }

    /**
     * 删除部门
     * @param int $id 部门id。（注：不能删除根部门；不能删除含有子部门、成员的部门）
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function delete($id)
    {
        return $this->request('get', self::DEPARTMENT_DELETE, ['id' => $id]);
    }

    /**
     * 获取部门列表
     * @param int|null $id 部门id。获取指定部门及其下的子部门。 如果不填，默认获取全量组织架构
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function lists($id = null)
    {
        $query_param = [];

        !is_null($id) && $query_param['id'] = $id;

        return $this->request('get', self::DEPARTMENT_LIST, $query_param);
    }
}