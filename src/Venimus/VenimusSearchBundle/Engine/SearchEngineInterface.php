<?php
namespace Venimus\VenimusSearchBundle\Engine;

use Venimus\VenimusSearchBundle\Factory\ResultSetFactoryInterface;
use Venimus\VenimusSearchBundle\Model\IndexableInterface;
use Venimus\VenimusSearchBundle\Model\ResultSetInterface;
use Venimus\VenimusSearchBundle\Query\QueryInterface;

/**
 * Bridge Interface for a Search engine that will provide public methods for indexing and searching data (e.g. files).
 * Decouples the public interface from the Index provider (storage)
 *
 * Interface SearchEngineInterface
 * @package Venimus\VenimusSearchBundle\Index
 */
interface SearchEngineInterface
{
    /**
     * Add a single entity to the engine
     *
     * @param IndexableInterface $indexable
     * @return mixed
     */
    public function index(IndexableInterface $indexable);

    /**
     * Clear the engine buffers and all indexed data.
     *
     * @param IndexableInterface $indexable
     */
    public function remove(IndexableInterface $indexable);

    /**
     * Finish a indexing batch. Client should call it to indicate the end of indexing.
     *
     * @return void
     */
    public function flush();

    /**
     * Search the indexed data by provided Query
     *
     * @param QueryInterface $query
     * @return ResultSetInterface
     */
    public function search(QueryInterface $query);
}
