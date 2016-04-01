<?php

namespace Venimus\VenimusSearchBundle\Model;

use Venimus\VenimusSearchBundle\Query\QueryInterface;

/**
 * Class KeysResultSet
 * Simple ResultSet implementation that Constructs ResultSet containing only the array keys of $results
 *
 * @package Venimus\VenimusSearchBundle\Model
 */
class KeysResultSet implements ResultSetInterface
{
    /**
     * @var mixed
     */
    private $results;
    /**
     * @var string
     */
    private $query;

    /**
     * KeysResultSet constructor.
     * @param $results
     */
    public function __construct($results, QueryInterface $query)
    {
        $this->results = array_keys((array)$results);
        $this->query = $query;
    }

    /**
     * Retrieve an external iterator
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->results);
    }

    /**
     * @return int The total count of the resultset.
     */
    public function count()
    {
        return count($this->results);
    }

    /**
     * Get the query that built the resultset. Could be used for building caches
     * @return QueryInterface
     */
    public function getQuery()
    {
        return $this->query;
    }
}
