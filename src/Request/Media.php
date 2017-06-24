<?php

namespace pithyone\wechat\Request;

class Media extends Api
{
    const MEDIA_UPLOAD = 'media/upload';
    const MEDIA_GET = 'media/get';

    /**
     * 上传临时素材文件
     * @param string $type 媒体文件类型，分别有图片（image）、语音（voice）、视频（video），普通文件(file)
     * @param array $data
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function upload($type, $data)
    {
        return $this->request('upload', self::MEDIA_UPLOAD, $data, ['type' => $type]);
    }

    /**
     * 获取临时素材文件
     * @param string $media_id 媒体文件id。最大长度为256字节
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function get($media_id)
    {
        return $this->request('get', self::MEDIA_GET, ['media_id' => $media_id]);
    }
}