<?php
namespace RedashApiCli\Api;

use RedashApiCli\Client as Client;

/**
 * Base
 *
 * @package sakatuki/redash-api-client
 * @version $id$
 * @author Saka <sakatuki@me.com>
 * @license MIT
 */
class Base
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->setClient($client);
    }
    /**
     * setClient
     *
     * @param mixed $client
     * @access public
     * @return void
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * getClient
     *
     * @access public
     * @return RedashApiCli\Client
     */
    public function getClient()
    {
        return $this->client;
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
}
