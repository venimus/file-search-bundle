<?php

namespace Venimus\VenimusSearchBundle\Engine;

use Venimus\VenimusSearchBundle\Engine\Storage\StorageInterface;
use Venimus\VenimusSearchBundle\Factory\ResultSetFactoryInterface;
use Venimus\VenimusSearchBundle\Model\IndexableInterface;
use Venimus\VenimusSearchBundle\Model\ResultSetInterface;
use Venimus\VenimusSearchBundle\Query\QueryInterface;

/**
 * Class Search
 * Bridge that provides a public interface to a search engine provider that implements a StorageInterface (DB adapter)
 * It allows to decouple the client interface from the implementation and to configure the engine provider
 *
 * @package Venimus\VenimusSearchBundle\Engine
 */
class Search implements SearchEngineInterface
{
    /**
     * Storage adapter to access a DB storage. Index does not need to know how to access the database storage
     * as long the adapter implements the required interface.
     *
     * @var StorageInterface
     */
    private $storage;
    /**
     * @var ResultSetFactoryInterface
     */
    private $resultFactory;

    /**
     * Search constructor.
     * @param StorageInterface $storage
     * @param ResultSetFactoryInterface $resultFactory
     */
    public function __construct(StorageInterface $storage, ResultSetFactoryInterface $resultFactory)
    {
        $this->storage = $storage;
        $this->resultFactory = $resultFactory;
    }

    /**
     * Creates or updates a indexable into the Storage.
     *
     * @param IndexableInterface $indexable
     * @return void
     */
    public function index(IndexableInterface $indexable)
    {
        $this->storage->persist($indexable);
    }

    /**
     * Forces the Storage to flush the indexed data
     */
    public function flush()
    {
        $this->storage->flush();
    }

    /**
     * Search the engine storage and return the matching identifiers
     *
     * @param QueryInterface $query
     * @return ResultSetInterface
     */
    public function search(QueryInterface $query)
    {
        $results = $this->storage->getMatching((string)$query->getQuery());
        return $this->resultFactory->fromArray($results, $query);
    }

    /**
     * Clear the engine buffers and all indexed data.
     *
     * @param IndexableInterface $indexable
     */
    public function remove(IndexableInterface $indexable)
    {
        $this->storage->remove($indexable);
    }
}
