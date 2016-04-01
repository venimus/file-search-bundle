<?php

namespace Venimus\VenimusSearchBundle\Factory;


use Venimus\VenimusSearchBundle\Model\KeysResultSet;
use Venimus\VenimusSearchBundle\Query\QueryInterface;

class IdentifiersResultSetFactory implements ResultSetFactoryInterface
{
    public function fromArray(array $results, QueryInterface $query)
    {
        return new KeysResultSet($results, $query);
    }
}
