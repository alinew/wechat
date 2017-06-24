<?php

namespace pithyone\wechat\Request;

use pithyone\wechat\CacheInterface;
use pithyone\wechat\Exception\WorkWeChatException;

class Js extends Api
{
    const GET_TICKET = 'get_jsapi_ticket';

    /**
     * 获取企业微信JS接口临时票据，返回临时票据字符串
     * @param string $corp_id
     * @param CacheInterface $cache
     * @return mixed
     * @throws WorkWeChatException
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function getTicketString($corp_id, CacheInterface $cache)
    {
        $cache_id = "jsapi_ticket_{$corp_id}_string";

        $ticket = $cache->fetch($cache_id);
        if ($ticket) {
            return $ticket;
        }

        $response = $this->getTicket();

        $ticket = $response['ticket'];

        $cache->save($cache_id, $ticket, $response['expires_in'] - 1500);

        return $ticket;
    }

    /**
     * 获取企业微信JS接口临时票据，返回临时票据字符串和过期时间数组
     * @param string $corp_id
     * @param CacheInterface $cache
     * @return mixed
     * @throws WorkWeChatException
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function getTicketArray($corp_id, CacheInterface $cache)
    {
        $cache_id = "jsapi_ticket_{$corp_id}_array";

        $data = $cache->fetch($cache_id);
        if ($data) {
            return ['ticket' => $data['ticket'], 'invalid' => $data['expire'] - (time() - $data['time'])];
        }

        $response = $this->getTicket();

        $ticket = $response['ticket'];

        $expires_in = $response['expires_in'] - 500;

        $data = ['ticket' => $ticket, 'time' => time(), 'expire' => $expires_in];

        $cache->save($cache_id, $data, $expires_in);

        return ['ticket' => $ticket, 'invalid' => $data['expire'] - (time() - $data['time'])];
    }

    /**
     * @return mixed
     * @throws WorkWeChatException
     * @author wangbing <pithyone@vip.qq.com>
     */
    protected function getTicket()
    {
        $response = $this->request('get', self::GET_TICKET);

        if (!isset($response['ticket']) || empty($response['ticket'])) {
            throw new WorkWeChatException('get js api ticket error');
        }

        return $response;
    }
}