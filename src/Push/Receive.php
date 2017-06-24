<?php

namespace pithyone\wechat\Push;

use pithyone\wechat\crypt\Message;
use pithyone\wechat\Exception\WorkWeChatException;

class Receive
{
    use Reply;

    /**
     * @var string
     */
    public $decryptEchoStr = '';

    /**
     * @var mixed
     */
    public $decryptMessage = [];

    /**
     * @var Message
     */
    private $message;

    /**
     * @var string
     */
    private $aesKey;

    /**
     * @param $corp_id
     * @param $token
     * @param $aes_key
     */
    public function __construct($corp_id, $token, $aes_key)
    {
        $this->aesKey = $aes_key;

        $this->message = new Message($token, $aes_key, $corp_id);

        $echo_str = $this->getSign('echostr');

        if ($echo_str) $this->verifyUrl($echo_str);
        else $this->decrypt();
    }

    /**
     * @return bool
     * @throws WorkWeChatException
     * @author wangbing <pithyone@vip.qq.com>
     */
    protected function decrypt()
    {
        $decrypt_message = '';

        $error_code = $this->message->decrypt($this->getSign('msg_signature'), $this->getSign('timestamp'), $this->getSign('nonce'), $this->getInput(), $decrypt_message);

        if ($error_code != 0 || empty($decrypt_message)) {
            throw new WorkWeChatException('message decrypt error', $error_code);
        }

        $xml = simplexml_load_string($decrypt_message, "SimpleXMLElement", LIBXML_NOCDATA);

        $this->decryptMessage = $this->xml2array($xml);

        return true;
    }

    /**
     * @param $xml
     * @return array
     * @author wangbing <pithyone@vip.qq.com>
     */
    private function xml2array($xml)
    {
        $json = json_encode($xml);
        $array = json_decode($json, true);

        return $array;
    }

    /**
     * 验证URL有效性
     * @param string $echo_str 加密的随机字符串，以msg_encrypt格式提供。需要解密并返回echostr明文，解密后有random、msg_len、msg、$CorpID四个字段，其中msg即为echostr明文
     * @return bool
     * @throws WorkWeChatException
     * @author wangbing <pithyone@vip.qq.com>
     */
    protected function verifyUrl($echo_str)
    {
        $error_code = $this->message->verifyUrl($this->getSign('msg_signature'), $this->getSign('timestamp'), $this->getSign('nonce'), $echo_str, $this->decryptEchoStr);

        if ($error_code != 0) {
            throw new WorkWeChatException('verify url error', $error_code);
        }

        return true;
    }

    /**
     * @return mixed
     */
    protected function getInput()
    {
        return file_get_contents("php://input");
    }

    /**
     * @param $key
     * @return string
     * @author wangbing <pithyone@vip.qq.com>
     */
    protected function getSign($key)
    {
        return isset($_GET[$key]) ? rawurldecode($_GET[$key]) : '';
    }

    /**
     * @param $name
     * @return mixed|string
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function __get($name)
    {
        return isset($this->decryptMessage[$name]) ? $this->decryptMessage[$name] : $this->$name;
    }

    /**
     * @return string
     */
    protected function getFromUserName()
    {
        return $this->ToUserName;
    }

    /**
     * @return string
     */
    protected function getToUserName()
    {
        return $this->FromUserName;
    }

    /**
     * @return Message
     */
    protected function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    protected function getAesKey()
    {
        return $this->aesKey;
    }
}