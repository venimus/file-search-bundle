<?php
namespace Factory;


use Venimus\VenimusSearchBundle\Factory\IdentifiersResultSetFactory;
use Venimus\VenimusSearchBundle\Query\PlainTextQuery;

class IdentifiersResultSetFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider dataProvider
     */
    public function testFromArray($results)
    {
        $factory = new IdentifiersResultSetFactory();
        $this->assertInstanceOf('Venimus\VenimusSearchBundle\Model\KeysResultSet', $factory->fromArray($results, new PlainTextQuery('test')));
    }

    public function dataProvider()
    {
        return [
            [['test' => 'content']],
            [[0 => 'test1', 1 => 'test2']]
        ];
    }
}
