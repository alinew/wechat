<?php

namespace pithyone\wechat\Request;

class User extends Api
{
    const USER_CREATE = 'user/create';
    const USER_GET = 'user/get';
    const USER_UPDATE = 'user/update';
    const USER_DELETE = 'user/delete';
    const USER_BATCH_DELETE = 'user/batchdelete';
    const USER_SIMPLE_LIST = 'user/simplelist';
    const USER_LIST = 'user/list';

    /**
     * 创建成员
     * @param array $data
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function create($data)
    {
        return $this->request('post', self::USER_CREATE, $data);
    }

    /**
     * 获取成员
     * @param string $user_id 成员UserID。对应管理端的帐号
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function get($user_id)
    {
        return $this->request('get', self::USER_GET, ['userid' => $user_id]);
    }

    /**
     * 更新成员
     * @param array $data
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function update($data)
    {
        return $this->request('post', self::USER_UPDATE, $data);
    }

    /**
     * 删除成员
     * @param string $user_id 成员UserID。对应管理端的帐号
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function delete($user_id)
    {
        return $this->request('get', self::USER_DELETE, ['userid' => $user_id]);
    }

    /**
     * 批量删除成员
     * @param array $user_id_list 成员UserID列表。对应管理端的帐号
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function batchDelete($user_id_list)
    {
        return $this->request('post', self::USER_BATCH_DELETE, ['useridlist' => $user_id_list]);
    }


    /**
     * 获取部门成员
     * @param int $department_id 获取的部门id
     * @param int $fetch_child 1/0：是否递归获取子部门下面的成员
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function simpleLists($department_id, $fetch_child = 0)
    {
        return $this->request('get', self::USER_SIMPLE_LIST, ['department_id' => $department_id, 'fetch_child' => $fetch_child]);
    }

    /**
     * 获取部门成员(详情)
     * @param int $department_id 获取的部门id
     * @param int $fetch_child 1/0：是否递归获取子部门下面的成员
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function lists($department_id, $fetch_child = 0)
    {
        return $this->request('get', self::USER_LIST, ['department_id' => $department_id, 'fetch_child' => $fetch_child]);
    }
}