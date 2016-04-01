<?php

namespace Query;

use Venimus\VenimusSearchBundle\Query\PlainTextQuery;

class PlainTextQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetQuery()
    {
        $query = new PlainTextQuery('test');
        $this->assertEquals('test', $query->getQuery());
    }
}
