<?php
/**
 * Created by PhpStorm.
 * User: S.Belichenko, email: stanislav@priceva.com
 * Date: 11.10.2018
 * Time: 8:47
 */

namespace Priceva;


class FilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Filter $Filter
     */
    private $Filter;

    protected function setUp()
    {
        $this->Filter = new Filter();
    }

    protected function tearDown()
    {
        unset($this->Filter);
    }

    /**
     * @return Filter
     */
    public function testOffsetSet()
    {
        $this->Filter[ 'page' ]        = 1;
        $this->Filter[ 'limit' ]       = 2;
        $this->Filter[ 'category_id' ] = 3;

        return $this->Filter;
    }

    /**
     * @depends testOffsetSet
     *
     * @param Filter $filter
     */
    public function testGet_array( $filter )
    {
        $this->AssertEquals($filter->get_array(), [
            'page'        => 1,
            'limit'       => 2,
            'category_id' => 3,
        ]);
    }

    /**
     * @depends testOffsetSet
     *
     * @param Filter $filter
     */
    public function testOffsetGet( $filter )
    {
        echo $filter[ 'page' ];
    }

    /**
     * @depends testOffsetSet
     *
     * @param Filter $filter
     */
    public function testOffsetExists( $filter )
    {
        $this->assertTrue($filter->offsetExists('page'));

    }

    /**
     * @expectedException \Priceva\PricevaException
     * @expectedExceptionMessage You can use only valid parameter names.
     */
    public function testOffsetSetThrowException()
    {
        $this->Filter[ 'wrong_param' ] = 1;
    }

    /**
     * @depends testOffsetSet
     *
     * @param Filter $filter
     */
    public function testCount( $filter )
    {
        $this->assertEquals(count($filter), 3);
    }

    /**
     * @depends testOffsetSet
     *
     * @param Filter $filter
     */
    public function testOffsetUnset( $filter )
    {
        unset($filter[ 'page' ]);
        $this->assertEquals(count($filter), 2);
    }
}
