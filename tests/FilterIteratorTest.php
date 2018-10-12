<?php
/**
 * Created by PhpStorm.
 * User: S.Belichenko, email: stanislav@priceva.com
 * Date: 12.10.2018
 * Time: 9:09
 */

namespace Priceva;


class FilterIteratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Filter $Filter
     */
    private $Filter;

    protected function setUp()
    {
        $this->Filter = new Filter();

        $this->Filter[ 'page' ]        = 1;
        $this->Filter[ 'limit' ]       = 2;
        $this->Filter[ 'category_id' ] = 3;
    }

    protected function tearDown()
    {
        unset($this->Filter);
    }

    public function testRewind()
    {
        foreach( $this->Filter as $filter ){
            $first = $filter;
            $this->assertEquals($first, 1);

            return;
        }

        $this->fail('testRewind failed.');
    }

    public function test__construct()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    public function testValid()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    public function testKey()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    public function testNext()
    {
        $i = 0;
        foreach( $this->Filter as $filter ){
            $i++;

            if( $i === 2 ){
                $second = $filter;
                $this->assertEquals($second, 2);

                return;
            }
        }

        $this->fail('testNext failed.');
    }

    public function testCurrent()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
