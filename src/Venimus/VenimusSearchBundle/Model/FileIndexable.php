<?php

namespace Venimus\VenimusSearchBundle\Model;

/**
 * Class FileIndexable
 * Holds a indexed file data
 *
 * @package Venimus\VenimusSearchBundle\Model
 */
class FileIndexable implements IndexableInterface
{
    /**
     * @var string The filename to engine
     */
    private $filename;

    /**
     * Indexable type.
     * @var string
     */
    private $type = 'File';

    /**
     * FileIndexable constructor.
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->filename;
    }

    /**
     * Retrieves the contents of the file
     * @return string
     */
    public function getContent()
    {
        return (string)file_get_contents($this->filename);
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
