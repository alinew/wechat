<?php

namespace pithyone\wechat\Request;

class Agent extends Api
{
    const AGENT_GET = 'agent/get';
    const AGENT_SET = 'agent/set';
    const AGENT_LIST = 'agent/list';

    /**
     * 获取应用
     * @param int $agent_id 授权方应用id
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function get($agent_id)
    {
        return $this->request('get', self::AGENT_GET, ['agentid' => $agent_id]);
    }

    /**
     * 设置应用
     * @param array $data
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function set($data)
    {
        return $this->request('post', self::AGENT_SET, $data);
    }

    /**
     * 获取应用概况列表
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function lists()
    {
        return $this->request('get', self::AGENT_LIST);
    }
}