<?php
namespace Venimus\VenimusSearchBundle\Engine\Storage;

use Venimus\VenimusSearchBundle\Model\IndexableInterface;


/**
 * Interface StorageInterface
 * Interface for Search Index Storage.
 * This is the implementation part of the Search bridge
 */
interface StorageInterface
{
    /**
     * Return one Indexable by its unique identifier
     * @param $identifier
     * @return IndexableInterface
     */
    public function get($identifier);

    /**
     * Persists an Indexable to the engine
     * @param IndexableInterface $entity
     * @return void
     */
    public function persist(IndexableInterface $entity);

    /**
     * Indicates that indexing is finished by the client.
     * @return void
     */
    public function flush();

    /**
     * Remove Indexable by its identifier
     * @return void
     */
    public function remove($identifier);

    /**
     * Performs a search in the engine and returns array of identifiers
     * @param $searchString
     * @return array
     */
    public function getMatching($searchString);
}
