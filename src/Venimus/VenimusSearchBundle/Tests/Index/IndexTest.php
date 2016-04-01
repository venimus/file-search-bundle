<?php

namespace Index;


use Venimus\VenimusSearchBundle\Entity\Index;

class IndexTest extends \PHPUnit_Framework_TestCase
{

    public function testIdentifier()
    {
        $index = new Index();
        $this->assertNull($index->getIdentifier());
        $index->setIdentifier('text');
        $this->assertEquals('test', $index->getIdentifier());
    }

    public function testContent()
    {
        $index = new Index();
        $this->assertNull($index->getContent());
        $index->setContent('text');
        $this->assertEquals('test', $index->getContent());
    }
}
