<?php

namespace pithyone\wechat\Request;

use pithyone\wechat\Exception\WorkWeChatException;
use pithyone\wechat\Http\HttpInterface;

class Api
{
    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var HttpInterface
     */
    protected $http;

    public function __construct(HttpInterface $http, $accessToken = '')
    {
        $this->http = $http;
        $this->accessToken = $accessToken;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $data
     * @param array $data2
     * @return mixed
     * @throws \Exception
     * @author wangbing <pithyone@vip.qq.com>
     */
    protected function request($method, $uri, $data = [], $data2 = [])
    {
        $query_param = ['access_token' => $this->accessToken];

        $data2 && $query_param = array_merge($query_param, $data2);

        if ($method == 'get') {
            $data && $query_param = array_merge($query_param, $data);
            $response = $this->http->$method($uri, $query_param);
        } else {
            $response = $this->http->$method($uri, $data, $query_param);
        }

        return $this->response($response);
    }

    /**
     * @param $response
     * @return mixed
     * @throws \Exception
     * @author wangbing <pithyone@vip.qq.com>
     */
    protected function response($response)
    {
        try {
            $ret = \GuzzleHttp\json_decode($response, true);

            if (isset($ret['errcode']) && 0 !== $ret['errcode']) {
                throw new WorkWeChatException($ret['errmsg'] ?: 'unknown error message', $ret['errcode']);
            }

            return $ret;
        } catch (\InvalidArgumentException $e) {
            return $response;
        }
    }
}