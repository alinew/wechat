<?php

namespace pithyone\wechat\Http;

interface HttpInterface
{
    /**
     * @param string $uri
     * @param mixed $query_param
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function get($uri, $query_param = []);

    /**
     * @param string $uri
     * @param mixed $json
     * @param mixed $query_param
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function post($uri, $json = [], $query_param = []);

    /**
     * @param string $uri
     * @param array $files eg: ['file_name' => /path/to/file]
     * @param mixed $query_param
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function upload($uri, $files, $query_param = []);
}