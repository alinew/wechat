<?php

namespace pithyone\wechat\Request;

class OAuth extends Api
{
    const USER_GET_USER_INFO = 'user/getuserinfo';
    const USER_GET_USER_DETAIL = 'user/getuserdetail';

    /**
     * 根据code获取成员信息
     * @param string $code 通过成员授权获取到的code，每次成员授权带上的code将不一样，code只能使用一次，10分钟未被使用自动过期
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function getUserInfo($code)
    {
        return $this->request('get', self::USER_GET_USER_INFO, ['code' => $code]);
    }

    /**
     * 使用user_ticket获取成员详情
     * @param $user_ticket
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function getUserDetail($user_ticket)
    {
        return $this->request('post', self::USER_GET_USER_DETAIL, ['user_ticket' => $user_ticket]);
    }
}