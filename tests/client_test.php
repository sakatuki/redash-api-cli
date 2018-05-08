<?php
use PHPUnit\Framework\TestCase as TestCase;
use RedashApiCli\Client as RedashApiClient;
use RedashApiCli\Api\Queries as RedashApiQueries;

/**
 * ClientTest
 *
 * @uses TestCase
 * @package
 * @version $id$
 * @author Saka <sakatuki@me.com>
 * @license PHP Version 3.0 {@link http://www.php.net/license/3_0.txt}
 */
class ClientTest extends TestCase
{
    protected $apiQueries;
    static $queryId = 1;
    private static $responseTypeGetQuery = [
        'id'                        => 'integer',
        'schedule'                  => 'string',
        'is_archived'               => 'boolean',
        'query'                     => 'string',
        'is_draft'                  => 'boolean',
        'description'               => 'string',
        'name'                      => 'string',
        'data_source_id'            => 'integer',
    ];

    public function setUp()
    {
        $redashApiCli = new RedashApiClient(
            'https://your-redash.com',
            'your api key'
        );
        $this->apiQueries =  new RedashApiQueries($redashApiCli);
    }
    public function testRegistQuery()
    {
        $data = $this->apiQueries->registQuery(
            'select * from test_query limit 1;',
            'PHPUnitTest',
            'For PHPUnitTest',
            1,
            '864800'
        );

        foreach (self::$responseTypeGetQuery as $property => $type) {
            $this->assertTrue(property_exists($data, $property), 'At ' . $property);
            $this->assertEquals(gettype($data->$property), $type, 'At ' . $property);
        }
        $res = $this->apiQueries->deleteQuery($data->id);
    }

    public function testUpdateQuery()
    {
        $res = $this->apiQueries->updateQuery(self::$queryId, 'test');
        $this->assertEquals('test', $res->query);
    }

    public function testDeleteQuery()
    {
        $res = $this->apiQueries->deleteQuery(self::$queryId);
        $this->assertTrue(is_null($res));

        $res = $this->apiQueries->getQuery(self::$queryId);
        $this->assertTrue($res->is_archived);
    }


    public function testGetQuery()
    {
        $data = $this->apiQueries->getQuery(1);

        foreach (self::$responseTypeGetQuery as $property => $type) {
            $this->assertTrue(property_exists($data, $property), 'At ' . $property);
            if (! is_null($data->$property)) {
                $this->assertEquals(gettype($data->$property), $type, 'At ' . $property);
            }
        }
    }

    public function testGetQueries()
    {
        $res = $this->apiQueries->getQueries(1, 1);
        $this->assertEquals(1, $res->page);
        $this->assertEquals(1, $res->page_size);
        $result = $res->results;
        foreach ($result as $data) {
            foreach (self::$responseTypeGetQuery as $property => $type) {
                $this->assertTrue(property_exists($data, $property), 'At ' . $property);
                if (! is_null($data->$property)) {
                    $this->assertEquals(gettype($data->$property), $type, 'At ' . $property);
                }
            }
        }
    }

    public function testSearchQuery()
    {
        $result = $this->apiQueries->searchQueries('test');
        foreach ($result as $data) {
            foreach (self::$responseTypeGetQuery as $property => $type) {
                $this->assertTrue(property_exists($data, $property), 'At ' . $property);
                $this->assertEquals(gettype($data->$property), $type, 'At ' . $property);
            }
        }
    }
}
