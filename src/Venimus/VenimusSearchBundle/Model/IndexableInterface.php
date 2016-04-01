<?php

namespace Venimus\VenimusSearchBundle\Model;

/**
 * Interface IndexableInterface
 * This interface should be implemented by each the entity that holds a single piece of indexable data
 * It is used to abstract the indexing storage
 *
 * @package Venimus\VenimusSearchBundle\Model
 */
interface IndexableInterface
{
    /**
     * Sets index data type.
     * @param string $type
     */
    public function setType($type);

    /**
     * Could be used to filter index data
     * @return string
     */
    public function getType();

    /**
     * Retrieves an identifier of the indexed data
     * @return string
     */
    public function getIdentifier();

    /**
     * Retrieves the indexed data
     * @return string
     */
    public function getContent();
}
