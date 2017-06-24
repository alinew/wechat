<?php

namespace pithyone\wechat\Request;

use pithyone\wechat\CacheInterface;
use pithyone\wechat\Exception\WorkWeChatException;

class Token extends Api
{
    const GET = 'gettoken';

    /**
     * @param string $corp_id
     * @param string $secret
     * @param CacheInterface $cache
     * @return string
     * @throws WorkWeChatException
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function get($corp_id, $secret, CacheInterface $cache)
    {
        $cache_id = "access_token_{$corp_id}_" . md5($secret);

        $access_token = $cache->fetch($cache_id);

        if ($access_token) {
            return $access_token;
        }

        $response = $this->request('get', self::GET, ['corpid' => $corp_id, 'corpsecret' => $secret]);

        if (!isset($response['access_token']) || empty($response['access_token'])) {
            throw new WorkWeChatException('get access token error');
        }

        $access_token = $response['access_token'];

        $cache->save($cache_id, $access_token, $response['expires_in'] - 1500);

        return $access_token;
    }
}