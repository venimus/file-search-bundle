<?php

namespace Venimus\VenimusSearchBundle\Query;

class PlainTextQuery implements QueryInterface
{
    private $searchString;

    public function __construct($searchString)
    {
        $this->searchString = $searchString;
    }

    public function getQuery()
    {
        return (string)$this->searchString;
    }
}
