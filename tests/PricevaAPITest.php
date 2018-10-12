<?php
/**
 * Created by PhpStorm.
 * S.Belichenko, email: stanislav@priceva.com
 * Date: 09.10.2018
 * Time: 10:09
 */

namespace Priceva;


class PricevaAPITest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PricevaAPI
     */
    private $PricevaAPI;

    protected function setUp()
    {
        $this->PricevaAPI = new PricevaAPI('wrong_key');
    }

    protected function tearDown()
    {
        unset($this->PricevaAPI);
    }

    public function test__construct()
    {
        $this->assertInstanceOf('Priceva\PricevaAPI', $this->PricevaAPI);
    }

    /**
     * @throws PricevaException
     */
    public function testSet_filterObject()
    {
        $filter_obj           = new Filter();
        $filter_obj[ 'page' ] = 1;
        $this->PricevaAPI->set_filter($filter_obj);
        $this->AssertEquals($this->PricevaAPI->get_filter()->get_array(), [
            'page' => 1,
        ]);
    }

    /**
     * @throws PricevaException
     */
    public function testSet_filterArray()
    {
        $filter_arr[ 'page' ] = 1;
        $this->PricevaAPI->set_filter($filter_arr);
        $this->AssertEquals($this->PricevaAPI->get_filter()->get_array(), [
            'page' => 1,
        ]);
    }

    /**
     * @throws PricevaException
     */
    public function testSet_filterAgain()
    {
        $filter_arr            = [];
        $filter_arr[ 'limit' ] = 1;
        $this->PricevaAPI->set_filter($filter_arr);

        $filter_obj           = new Filter();
        $filter_obj[ 'page' ] = 1;
        $this->PricevaAPI->set_filter($filter_obj);

        $this->AssertEquals($this->PricevaAPI->get_filter()->get_array(), [
            'page'  => 1,
            'limit' => 1,
        ]);
    }

    /**
     * @expectedException \Priceva\PricevaException
     * @expectedExceptionMessage Wrong type of the filter.
     */
    public function testSet_filterThrowException()
    {
        $filter_arr = 'page';
        /** @noinspection PhpParamsInspection */
        $this->PricevaAPI->set_filter($filter_arr);
    }

    /**
     * @throws PricevaException
     */
    public function testMain_demo()
    {
        $result = $this->PricevaAPI->main_demo();

        $this->assertInstanceOf('Priceva\Result', $result);
    }

    /**
     * @throws PricevaException
     */
    public function testMain_ping()
    {
        $result = $this->PricevaAPI->main_ping();

        $this->assertInstanceOf('Priceva\Result', $result);
    }

    /**
     * @dataProvider filters
     *
     * @param $filter
     *
     * @throws PricevaException
     */
    public function testProduct_list( $filter )
    {
        $result = $this->PricevaAPI->product_list($filter);

        $this->assertInstanceOf('Priceva\Result', $result);
    }

    /**
     * @dataProvider filters
     *
     * @param $filter
     *
     * @throws PricevaException
     */
    public function testReport_list( $filter )
    {
        $result = $this->PricevaAPI->report_list($filter);
        $this->assertInstanceOf('Priceva\Result', $result);
    }

    public function filters()
    {
        $filter_empty = new Filter();

        $filter_full           = new Filter();
        $filter_full[ 'page' ] = 1;

        return [
            [
                'FILTER' => [],
            ],
            [
                'FILTER' => [ 'page' => 1 ],
            ],
            [
                'FILTER' => $filter_empty,
            ],
            [
                'FILTER' => $filter_full,
            ],
        ];
    }
}
