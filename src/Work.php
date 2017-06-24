<?php

namespace pithyone\wechat;

use pithyone\wechat\crypt\PrpCrypt;
use Psr\Log\LoggerInterface;
use pithyone\wechat\Exception\WorkWeChatException;
use pithyone\wechat\Request\Agent;
use pithyone\wechat\Request\Batch;
use pithyone\wechat\Request\Department;
use pithyone\wechat\Request\IP;
use pithyone\wechat\Request\Js;
use pithyone\wechat\Request\Media;
use pithyone\wechat\Http\Guzzle;
use pithyone\wechat\Request\Menu;
use pithyone\wechat\Request\Message;
use pithyone\wechat\Request\OAuth;
use pithyone\wechat\Request\Tag;
use pithyone\wechat\Request\Token;
use pithyone\wechat\Request\User;
use pithyone\wechat\Push\Receive;

class Work
{
    const BASE_URI = 'https://qyapi.weixin.qq.com/cgi-bin/';

    /**
     * @var array
     */
    public $config;

    /**
     * @var Guzzle
     */
    public $guzzle;

    /**
     * @var array
     */
    protected $apiProvider = [
        'Agent' => Agent::class,
        'Batch' => Batch::class,
        'Department' => Department::class,
        'IP' => IP::class,
        'Js' => Js::class,
        'Media' => Media::class,
        'Menu' => Menu::class,
        'Message' => Message::class,
        'OAuth' => OAuth::class,
        'Tag' => Tag::class,
        'Token' => Token::class,
        'User' => User::class,
    ];

    /**
     * @param $config
     *
     * 'debug'  => false
     * 'corp_id' => 'corp_id'
     * 'secret' => 'secret'
     * 'token' => 'token'
     * 'aes_key' => 'aes_key'
     * 'cache' => WorkWeChat\Cache
     * 'logger' => Psr\Log\LoggerInterface
     * 'guzzle' => ['timeout' => 3.0]
     */
    public function __construct($config)
    {
        $this->config = $config;

        $this->initHttp();
    }

    /**
     * @throws WorkWeChatException
     * @author wangbing <pithyone@vip.qq.com>
     */
    protected function initHttp()
    {
        $config = $this->guzzle ?: [];

        $config['base_uri'] = self::BASE_URI;

        $debug = $this->debug !== '' ? $this->debug : false;

        if ($debug && ($this->logger === '' || !($this->logger instanceof LoggerInterface))) {
            throw new WorkWeChatException('when debug is true, logger must implements Psr\Log\LoggerInterface');
        }

        $this->guzzle = new Guzzle($config, $this->debug, $this->logger);
    }

    /**
     * @return mixed
     * @throws \Exception
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function getAccessToken()
    {
        if (!($this->cache instanceof CacheInterface)) {
            throw new WorkWeChatException('cache must implements WorkWeChat\CacheInterface');
        }

        $token = new Token($this->guzzle);

        return $token->get($this->corp_id, $this->secret, $this->cache);
    }

    /**
     * @param string $type
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function getJsApiTicket($type = 'string')
    {
        $access_token = $this->getAccessToken();

        $js = new Js($this->guzzle, $access_token);

        return $type == 'string' ? $js->getTicketString($this->corp_id, $this->cache) : $js->getTicketArray($this->corp_id, $this->cache);
    }

    /**
     * @return Receive
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function push()
    {
        return new Receive($this->corp_id, $this->token, $this->aes_key);
    }

    /**
     * @return array
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function jsSign()
    {
        $js_api_ticket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();

        $prpCrypt = new PrpCrypt($this->aes_key);
        $nonceStr = $prpCrypt->getRandomStr();

        //这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=" . $js_api_ticket . "&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId" => $this->corp_id,
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string
        );

        return $signPackage;
    }

    /**
     * @param $name
     * @return mixed
     * @throws WorkWeChatException
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function api($name)
    {
        $access_token = $this->getAccessToken();

        if (!isset($this->apiProvider[$name])) {
            throw new WorkWeChatException($name . ' api is not set');
        }

        return new $this->apiProvider[$name]($this->guzzle, $access_token);
    }

    /**
     * @param $name
     * @return mixed|string
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function __get($name)
    {
        return isset($this->config[$name]) ? $this->config[$name] : '';
    }
}