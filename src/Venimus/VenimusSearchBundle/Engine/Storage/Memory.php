<?php

namespace Venimus\VenimusSearchBundle\Engine\Storage;

use Venimus\VenimusSearchBundle\Model\IndexableInterface;

/**
 * Class Memory
 *
 * Implements non-persistable engine in memory
 * It could be used to implement a search engine that does not require a database setup
 *
 * @package Venimus\VenimusSearchBundle\Index
 */
class Memory implements StorageInterface
{
    /**
     * Searchable engine storage
     * @var array
     */
    private $index = [];

    /**
     * Index single entry
     *
     * @param IndexableInterface $entity
     * @return void
     */
    public function persist(IndexableInterface $entity)
    {
        $this->index[$entity->getIdentifier()] = $entity->getContent();
    }

    /**
     * Remove indexed entry by id
     * @param $identifier
     */
    public function remove($identifier)
    {
        if (array_key_exists($identifier, $this->index)) {
            unset($this->index[$identifier]);
        }
    }

    /**
     * Search the engine for contents having given string
     *
     * @param string $searchString
     * @return array
     */
    public function getMatching($searchString)
    {
        $result = array_filter($this->index, function ($item) use ($searchString) {
            return strpos($item, $searchString) !== false;
        });

        return $result;
    }

    /**
     * @return void
     */
    public function flush()
    {
        // nothing to do
    }

    /**
     * Gets an entry from its id
     * @param $identifier
     * @return IndexableInterface
     */
    public function get($identifier)
    {
        return array_key_exists($identifier, $this->index) ? $this->index[$identifier] : null;
    }
}
