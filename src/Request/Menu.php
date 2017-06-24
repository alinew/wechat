<?php

namespace pithyone\wechat\Request;

class Menu extends Api
{
    const MENU_CREATE = 'menu/create';
    const MENU_GET = 'menu/get';
    const MENU_DELETE = 'menu/delete';

    /**
     * 创建应用菜单
     * @param int $agent_id 企业应用的id
     * @param array $data
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function create($agent_id, $data)
    {
        return $this->request('post', self::MENU_CREATE, $data, ['agentid' => $agent_id]);
    }

    /**
     * 获取菜单列表
     * @param int $agent_id 企业应用的id
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function get($agent_id)
    {
        return $this->request('get', self::MENU_GET, ['agentid' => $agent_id]);
    }

    /**
     * 删除应用菜单
     * @param int $agent_id 企业应用的id
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function delete($agent_id)
    {
        return $this->request('get', self::MENU_DELETE, ['agentid' => $agent_id]);
    }
}