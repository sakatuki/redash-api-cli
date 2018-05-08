<?php
namespace RedashApiCli\Api;

use RedashApiCli\Api\Base;

/**
 * Queries
 *
 * @uses Base
 * @package sakatuki/redash-api-client
 * @version $id$
 * @author Saka <sakatuki@me.com>
 * @license MIT
 */
class Queries extends Base
{
    /**
     * registQuery
     * return json_decode
     *
     * @access public
     * @return mixed
     */
    public function registQuery(
        String $query,
        String $queryName = '',
        String $queryDescription = '',
        Int $dataSourceId = 1,
        $schedule = null
    ) {
        $path = '/api/queries';
        $res = $this->client->post($path, [
        'data_source_id' => $dataSourceId,
        'query' => $query,
        'name' => $queryName,
        'description' => $queryDescription,
        'schedule' => $schedule
        ]);
        return self::decode($res->getBody());
    }


    /**
     * getQueries
     *
     * @param Int $page
     * @param Int $pageSize
     * @access public
     * @return mixed
     */
    public function getQueries(Int $page = 1, Int $pageSize = 25)
    {
        $path = '/api/queries';
        $res = $this->client->get($path, [
        'page' => $page,
        'page_size' => $pageSize,
        ]);
        return self::decode($res->getBody());
    }

    /**
     * getQuery
     *
     * @param Int $queryId
     * @access public
     * @return mixed
     */
    public function getQuery($queryId)
    {
        $path = "/api/queries/$queryId";
        $res = $this->client->get($path, [
        'id' => $queryId,
        ]);
        return self::decode($res->getBody());
    }

    /**
     * getQueryByName
     * Search query text, names, and descriptions.
     *
     * @param String $queryName
     * @access public
     * @return mixed
     */
    public function searchQueries(String $searchTxt = '')
    {
        $path = '/api/queries/search';
        $res = $this->client->get($path, [
        'q' => $searchTxt,
        ]);

        return self::decode($res->getBody());
    }

    /**
     * publishQuery
     *
     * @param Int $queryId
     * @access public
     * @return mixed
     */
    public function publishQuery($queryId)
    {
        $path = '/api/queries/'.$queryId;
        return $this->client->updateQuery($queryId, null, null, null, null, null, false);
    }

    /**
     * refreshQuery
     *
     * @param Int $queryId
     * @access public
     * @return mixed
     */
    public function refreshQuery($queryId)
    {
        $path = "/api/queries/$queryId/refresh";
        $res = $this->post($path, [
            'id' => $queryId,
        ]);
        return self::decode($res->getBody());
    }

    /**
     * updateQuery
     *
     * @param mixed $queryId
     * @param String $query
     * @param String $queryName
     * @param String $queryDescription
     * @param Int $dataSourceId
     * @param String $schedule
     * @access public
     * @return void
     */
    public function updateQuery(
        $queryId,
        ?String $query = null,
        ?String $queryName = null,
        ?String $queryDescription = null,
        ?Int $dataSourceId = null,
        ?String $schedule = null,
        ?Bool $isDraft = null,
        ?Bool $isArchived = null
    ) {
    
        $path = '/api/queries/'.$queryId;

        $updateParam = ['id' => $queryId];
        if (! is_null($query)) {
            $updateParam['query'] = $query;
        }
        if (! is_null($queryName)) {
            $updateParam['name'] = $queryName;
        }
        if (! is_null($queryDescription)) {
            $updateParam['description'] = $queryDescription;
        }
        if (! is_null($dataSourceId)) {
            $updateParam['data_source_id'] = $dataSourceId;
        }
        if (! is_null($schedule)) {
            $updateParam['schedule'] = $schedule;
        }
        if (! is_null($isDraft)) {
            $updateParam['is_draft'] = $isDraft;
        }
        if (! is_null($isArchived)) {
            $updateParam['is_archived'] = $isArchived;
        }
        $res = $this->client->post($path, $updateParam);
        return self::decode($res->getBody());
    }

    /**
     * deleteQuery
     *
     * @param mixed $queryId
     * @access public
     * @return mixed
     */
    public function deleteQuery($queryId)
    {
        $path = '/api/queries/'.$queryId;
        $res = $this->client->delete($path, []);
        return self::decode($res->getBody());
    }
}
