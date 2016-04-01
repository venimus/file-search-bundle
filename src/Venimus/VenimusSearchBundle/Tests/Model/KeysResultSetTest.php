<?php
namespace Model;

use Venimus\VenimusSearchBundle\Model\KeysResultSet;
use Venimus\VenimusSearchBundle\Query\PlainTextQuery;

class KeysResultSetTest extends \PHPUnit_Framework_TestCase
{
    private $keysResultSet;

    /**
     * @dataProvider happyResultsDataProvider
     */
    public function testGetIterator($results, $query)
    {
        $keysResultSet = new KeysResultSet($results, new PlainTextQuery($query));
        $this->assertInstanceOf('\Traversable', $keysResultSet);
    }

    /**
     * @dataProvider happyResultsDataProvider
     */
    public function testResultsContainsKeys($results, $query, $expected)
    {
        $keysResultSet = new KeysResultSet($results, new PlainTextQuery($query));
        $iterator = $keysResultSet->getIterator();

        $this->assertArrayHasKey($expected, array_keys($iterator));
        $this->assertCount(count($results), $iterator->count());
    }

    /**
     * @dataProvider happyResultsDataProvider
     */
    public function testResultsCount($results, $query)
    {
        $keysResultSet = new KeysResultSet($results, new PlainTextQuery($query));

        $this->assertCount(count($results), $keysResultSet);
    }

    public function testGetQuery()
    {
        $keysResultSet = new KeysResultSet([], new PlainTextQuery('query'));
        $this->assertInstanceOf('\Venimus\VenimusSearchBundle\Query\QueryInterface', $keysResultSet);
    }

    public function happyResultsDataProvider()
    {
        return array(
            array(['test' => 'content'], 'a', 'test'),
            array([0 => 'test1', 1 => 'test2'], 'a', 1),
        );
    }
}
