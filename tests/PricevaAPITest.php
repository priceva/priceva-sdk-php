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
    public function testSet_filtersObject()
    {
        $filters_obj           = new Filters();
        $filters_obj[ 'page' ] = 1;
        $this->PricevaAPI->set_filters($filters_obj);
        $this->AssertEquals($this->PricevaAPI->get_filters()->get_array(), [
            'page' => 1,
        ]);
    }

    /**
     * @throws PricevaException
     */
    public function testSet_filtersArray()
    {
        $filters_arr[ 'page' ] = 1;
        $this->PricevaAPI->set_filters($filters_arr);
        $this->AssertEquals($this->PricevaAPI->get_filters()->get_array(), [
            'page' => 1,
        ]);
    }

    /**
     * @throws PricevaException
     */
    public function testSet_filtersAgain()
    {
        $filters_arr            = [];
        $filters_arr[ 'limit' ] = 1;
        $this->PricevaAPI->set_filters($filters_arr);

        $filters_obj           = new Filters();
        $filters_obj[ 'page' ] = 1;
        $this->PricevaAPI->set_filters($filters_obj);

        $this->AssertEquals($this->PricevaAPI->get_filters()->get_array(), [
            'page'  => 1,
            'limit' => 1,
        ]);
    }

    /**
     * @expectedException \Priceva\PricevaException
     * @expectedExceptionMessage Filters must be an array or an object of type Filters.
     */
    public function testSet_filtersThrowException()
    {
        $filters_arr = 'page';
        /** @noinspection PhpParamsInspection */
        $this->PricevaAPI->set_filters($filters_arr);
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
     * @param $filters
     *
     * @throws PricevaException
     */
    public function testProduct_list( $filters )
    {
        $result = $this->PricevaAPI->product_list($filters);

        $this->assertInstanceOf('Priceva\Result', $result);
    }

    /**
     * @dataProvider filters
     *
     * @param $filters
     *
     * @throws PricevaException
     */
    public function testReport_list( $filters )
    {
        $result = $this->PricevaAPI->report_list($filters);
        $this->assertInstanceOf('Priceva\Result', $result);
    }

    public function filters()
    {
        $filters_empty = new Filters();

        $filters_full           = new Filters();
        $filters_full[ 'page' ] = 1;

        return [
            [
                'FILTERS' => [],
            ],
            [
                'FILTERS' => [ 'page' => 1 ],
            ],
            [
                'FILTERS' => $filters_empty,
            ],
            [
                'FILTERS' => $filters_full,
            ],
        ];
    }
}
