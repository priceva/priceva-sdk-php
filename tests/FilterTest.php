<?php
/**
 * Created by PhpStorm.
 * User: S.Belichenko, email: stanislav@priceva.com
 * Date: 11.10.2018
 * Time: 8:47
 */

namespace Priceva;


class FiltersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Filters $Filter
     */
    private $Filters;

    protected function setUp()
    {
        $this->Filters = new Filters();
    }

    protected function tearDown()
    {
        unset($this->Filters);
    }

    /**
     * @return Filters
     */
    public function testOffsetSet()
    {
        $this->Filters[ 'page' ]        = 1;
        $this->Filters[ 'limit' ]       = 2;
        $this->Filters[ 'category_id' ] = 3;

        return $this->Filters;
    }

    /**
     * @depends testOffsetSet
     *
     * @param Filters $filters
     */
    public function testGet_array( $filters )
    {
        $this->AssertEquals($filters->get_array(), [
            'page'        => 1,
            'limit'       => 2,
            'category_id' => 3,
        ]);
    }

    /**
     * @depends testOffsetSet
     *
     * @param Filters $filters
     */
    public function testOffsetGet( $filters )
    {
        echo $filters[ 'page' ];
    }

    /**
     * @depends testOffsetSet
     *
     * @param Filters $filters
     */
    public function testOffsetExists( $filters )
    {
        $this->assertTrue($filters->offsetExists('page'));

    }

    /**
     * @expectedException \Priceva\PricevaException
     * @expectedExceptionMessage You can use only valid parameter names.
     */
    public function testOffsetSetThrowException()
    {
        $this->Filters[ 'wrong_param' ] = 1;
    }

    /**
     * @depends testOffsetSet
     *
     * @param Filters $filters
     */
    public function testCount( $filters )
    {
        $this->assertEquals(count($filters), 3);
    }

    /**
     * @depends testOffsetSet
     *
     * @param Filters $filters
     */
    public function testOffsetUnset( $filters )
    {
        unset($filters[ 'page' ]);
        $this->assertEquals(count($filters), 2);
    }
}
