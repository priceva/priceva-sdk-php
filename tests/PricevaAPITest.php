<?php
/**
 * Created by PhpStorm.
 * S.Belichenko, email: stanislav@priceva.com
 * Date: 09.10.2018
 * Time: 10:09
 */

ini_set("log_errors", 1);
ini_set("display_errors", 0);
ini_set("error_log", __DIR__ . '/error.log');

use Priceva\PricevaAPI;

class PricevaAPITest extends PHPUnit_Framework_TestCase
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

    public function testMain_demo()
    {
        $result = $this->PricevaAPI->main_demo();

        $this->assertInstanceOf('Priceva\Result', $result);
    }

    public function testMain_ping()
    {
        $result = $this->PricevaAPI->main_ping();

        $this->assertInstanceOf('Priceva\Result', $result);
    }

    public function testProduct_list()
    {
        $result = $this->PricevaAPI->product_list();

        $this->assertInstanceOf('Priceva\Result', $result);
    }

    public function testReport_list()
    {
        $result = $this->PricevaAPI->report_list();

        $this->assertInstanceOf('Priceva\Result', $result);
    }
}
