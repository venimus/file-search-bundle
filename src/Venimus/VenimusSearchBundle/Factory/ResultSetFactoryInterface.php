<?php

namespace Venimus\VenimusSearchBundle\Factory;

use Venimus\VenimusSearchBundle\Query\QueryInterface;

interface ResultSetFactoryInterface
{
    public function fromArray(array $results, QueryInterface $query);
}
