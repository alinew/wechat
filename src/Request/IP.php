<?php

namespace pithyone\wechat\Request;

class IP extends Api
{
    const GET_CALLBACK_IP = 'getcallbackip';

    /**
     * 获取微信服务器的ip段
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function getCallbackIP()
    {
        return $this->request('get', self::GET_CALLBACK_IP);
    }
}