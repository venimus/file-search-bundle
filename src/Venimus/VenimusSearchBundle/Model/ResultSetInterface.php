<?php

namespace Venimus\VenimusSearchBundle\Model;

/**
 * Interface ResultSetInterface
 * ResultSetInterface is returned by SearchEngineInterface::search()
 * Extends \IteratorAggregate to provide interface for Traversing the results
 * Extends \Countable to provides interface to get the total count of results
 * While getIterator might be implemented to return only a partial set (pagination)
 *
 * @package Venimus\VenimusSearchBundle\Model
 */
interface ResultSetInterface extends \IteratorAggregate, \Countable
{

    /**
     * Retrieve the query that built the result set.
     *
     * @return mixed
     */
    public function getQuery();

    /**
     * from \IteratorAggregate
     * @return \Traversable
     * public function getIterator()
     */

    /**
     * from \Countable
     * @return int
     * public function count()
     */
}
