<?php

namespace RedashApiCli;

use \GuzzleHttp\Exception\RequestException as GuzzleHttpRequestException;
use \GuzzleHttp\Client as GuzzleHttpCli;

/**
 * Client
 *
 * @package sakatuki/redash-api-client
 * @version 1.0.0
 * @copyright sakatuki
 * @author Saka <sakatuki@me.com>
 * @license MIT
 */
class Client
{
    /**
     * url
     *
     * @var string
     * @access protected
     */
    protected $url = '';

    /**
     * apiKey
     *
     * @var string
     * @access protected
     */
    protected $apiKey = '';

    /**
     * client
     *
     * @var GuzzleHttpCli
     * @access protected
     */
    protected $client;

    /**
     * __construct
     *
     * @param string $url
     * @param string $apiKey
     * @access public
     * @return void
     */
    public function __construct(String $url, String $apiKey)
    {
        $this->setUrl($url);
        $this->setApiKey($apiKey);

        if (empty($this->getUrl())) {
            throw new \Exception("Url Not Defined.");
        }

        if (empty($this->getApiKey())) {
            throw new \Exception("ApiKey Not Exist.");
        }

        $this->client = new GuzzleHttpCli(
            [
                'base_uri' => $this->getUrl(),
                'headers' => [
                    'User-Agent' => 'PHP redash-api-cli',
                    'Authorization' => 'Key '.$this->getApiKey(),
                ]
            ]
        );
    }

    /**
     * setUrl
     *
     * @param String $url
     * @access public
     * @return void
     */
    public function setUrl(String $url)
    {
        $this->url = $url;
    }

    /**
     * getUrl
     *
     * @access public
     * @return String
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * setApiKey
     *
     * @param String $apiKey
     * @access public
     * @return void
     */
    public function setApiKey(String $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * getApiKey
     *
     * @access public
     * @return String
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * decode
     * json_decode
     *
     * @param String $str
     * @static
     * @access public
     * @return mixed
     */
    public static function decode(String $str)
    {
        return json_decode($str);
    }

    /**
     * post
     *
     * @param String $path
     * @param Array $params
     * @access public
     * @return GuzzleHttp\Psr7\Response
     */
    public function post(String $path, array $params)
    {
        return $this->request('POST', $path, ['json' => $params]);
    }

    /**
     * get
     *
     * @param String $path
     * @param Array $params
     * @access public
     * @return GuzzleHttp\Psr7\Response
     */
    public function get(String $path, array $params)
    {
        return $this->request('GET', $path, ['query' => $params]);
    }

    /**
     * delete
     *
     * @param String $path
     * @param array $params
     * @access public
     * @return GuzzleHttp\Psr7\Response
     */
    public function delete(String $path, array $params)
    {
        return $this->request('DELETE', $path, ['json' => $params]);
    }


    /**
     * request
     *
     * @param String $method
     * @param String $path
     * @param Array $params
     * @access public
     * @return GuzzleHttp\Psr7\Responsed
     */
    public function request(String $method, String $path, array $params)
    {
        try {
            $res = $this->client->request($method, $path, $params);
        } catch (GuzzleHttpRequestException $e) {
            echo $e->getMessage();
            throw new \Exception($e->getMessage());
        }
        return $res;
    }
}
