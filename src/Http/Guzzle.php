<?php

namespace pithyone\wechat\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Psr7\Request as Psr7Request;
use GuzzleHttp\Psr7\Response as Psr7Response;

class Guzzle implements HttpInterface
{
    const MAX_RETRIES = 3;

    /**
     * @var array
     */
    private $config;

    /**
     * @var bool
     */
    private $needLog;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param array $config
     * @param bool $debug
     * @param LoggerInterface|null $logger
     */
    public function __construct($config, $debug = false, $logger = null)
    {
        $this->config = $config;

        $this->needLog = $debug && ($logger instanceof LoggerInterface) ? true : false;

        $this->logger = $logger;
    }

    public function get($uri, $query_param = [])
    {
        return $this->request('GET', $uri, ['query' => $query_param]);
    }

    public function post($uri, $json = [], $query_param = [])
    {
        $options = [];

        $query_param && $options['query'] = $query_param;

        $json && $options['json'] = $json;

        return $this->request('POST', $uri, $options);
    }

    public function upload($uri, $files, $query_param = [])
    {
        $options = [];

        $query_param && $options['query'] = $query_param;

        foreach ($files as $name => $path) {
            $options['multipart'][] =
                [
                    'name' => $name,
                    'contents' => $this->getContents($path)
                ];
        }

        return $this->request('POST', $uri, $options);
    }

    /**
     * @param $path
     * @return mixed
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function getContents($path)
    {
        return fopen($path, 'r');
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return mixed
     * @throws \Exception
     * @author wangbing <pithyone@vip.qq.com>
     */
    public function request($method, $uri = '', $options = [])
    {
        $handler = $this->createHandler();

        $this->config['handler'] = $handler;

        $client = new Client($this->config);

        $response = $client->request($method, $uri, $options);

        return $response->getBody();
    }

    /**
     * @return HandlerStack
     * @author wangbing <pithyone@vip.qq.com>
     */
    protected function createHandler()
    {
        $stack = HandlerStack::create();

        if ($this->needLog) {
            $middleware_log = Middleware::log($this->logger, new MessageFormatter(MessageFormatter::DEBUG));
            $stack->push($middleware_log);
        }

        $middleware_retry = Middleware::retry($this->createRetryHandler($this->logger));
        $stack->push($middleware_retry);

        return $stack;
    }

    /**
     * @param LoggerInterface $logger
     * @return \Closure
     * @author wangbing <pithyone@vip.qq.com>
     */
    protected function createRetryHandler(LoggerInterface $logger)
    {
        return function (
            $retries,
            Psr7Request $request,
            Psr7Response $response = null,
            RequestException $exception = null
        ) use ($logger) {
            if ($retries >= self::MAX_RETRIES) {
                return false;
            }

            if (!($this->isServerError($response) || $this->isConnectError($exception))) {
                return false;
            }

            if ($this->needLog) {
                $logger->warning(sprintf(
                    'Retrying %s %s %s/%s, %s',
                    $request->getMethod(),
                    $request->getUri(),
                    $retries + 1,
                    self::MAX_RETRIES,
                    $response ? 'status code: ' . $response->getStatusCode() : $exception->getMessage()
                ), [$request->getHeader('Host')[0]]);
            }

            return true;
        };
    }

    /**
     * @param Psr7Response $response
     * @return bool
     */
    private function isServerError(Psr7Response $response = null)
    {
        return $response && $response->getStatusCode() >= 500;
    }

    /**
     * @param RequestException $exception
     * @return bool
     */
    private function isConnectError(RequestException $exception = null)
    {
        return $exception instanceof ConnectException;
    }
}