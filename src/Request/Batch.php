<?php

namespace pithyone\wechat\Request;

class Batch extends Api
{
    const BATCH_SYNC_USER = 'batch/syncuser';
    const BATCH_REPLACE_USER = 'batch/replaceuser';
    const BATCH_REPLACE_PARTY = 'batch/replaceparty';
    const BATCH_GET_RESULT = 'batch/getresult';

    /**
     * 增量更新成员
     * @param array $data
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function syncUser($data)
    {
        return $this->request('post', self::BATCH_SYNC_USER, $data);
    }

    /**
     * 全量覆盖成员
     * @param array $data
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function replaceUser($data)
    {
        return $this->request('post', self::BATCH_REPLACE_USER, $data);
    }

    /**
     * 全量覆盖部门
     * @param array $data
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function replaceParty($data)
    {
        return $this->request('post', self::BATCH_REPLACE_PARTY, $data);
    }

    /**
     * 获取异步任务结果
     * @param string $job_id 异步任务id，最大长度为64字节
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function result($job_id)
    {
        return $this->request('get', self::BATCH_GET_RESULT, ['jobid' => $job_id]);
    }
}