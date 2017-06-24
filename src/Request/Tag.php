<?php

namespace pithyone\wechat\Request;

class Tag extends Api
{
    const TAG_CREATE = 'tag/create';
    const TAG_UPDATE = 'tag/update';
    const TAG_DELETE = 'tag/delete';
    const TAG_GET = 'tag/get';
    const TAG_ADD_USER = 'tag/addtagusers';
    const TAG_DEL_USER = 'tag/deltagusers';
    const TAG_LIST = 'tag/list';

    /**
     * 创建标签
     * @param array $data
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function create($data)
    {
        return $this->request('post', self::TAG_CREATE, $data);
    }

    /**
     * 更新标签
     * @param array $data
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function update($data)
    {
        return $this->request('post', self::TAG_UPDATE, $data);
    }

    /**
     * 删除标签
     * @param int $tag_id 标签ID
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function delete($tag_id)
    {
        return $this->request('get', self::TAG_DELETE, ['tagid' => $tag_id]);
    }

    /**
     * 获取标签成员
     * @param int $tag_id 标签ID
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function get($tag_id)
    {
        return $this->request('get', self::TAG_GET, ['tagid' => $tag_id]);
    }

    /**
     * 增加标签成员
     * @param array $data
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function addUsers($data)
    {
        return $this->request('post', self::TAG_ADD_USER, $data);
    }

    /**
     * 删除标签成员
     * @param array $data
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function delUsers($data)
    {
        return $this->request('post', self::TAG_DEL_USER, $data);
    }

    /**
     * 获取标签列表
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function lists()
    {
        return $this->request('get', self::TAG_LIST);
    }
}