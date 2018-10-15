<?php
/**
 * Created by PhpStorm.
 * User: S.Belichenko, email: stanislav@priceva.com
 * Date: 11.10.2018
 * Time: 8:47
 */

namespace Priceva;


use Priceva\Contracts\Params;
use Priceva\Params\Filters;
use Priceva\Params\ProductFields;

class ParamsTest extends \PHPUnit_Framework_TestCase
{

    public function emptyParams()
    {
        $filters        = new Filters();
        $product_fields = new ProductFields();

        return [
            [
                $filters,
                'VALUES' => [
                    'page'        => 1,
                    'limit'       => 2,
                    'category_id' => 3,
                ],
            ],
            [
                $product_fields,
                'VALUES' => [
                    'client_code' => 1,
                    'articul'     => 2,
                    'name'        => 3,
                ],
            ],
        ];
    }

    public function fullyParams()
    {
        $filters        = new Filters();
        $product_fields = new ProductFields();

        $filters[ 'page' ]        = 1;
        $filters[ 'limit' ]       = 2;
        $filters[ 'category_id' ] = 3;

        $product_fields[ 'client_code' ] = 1;
        $product_fields[ 'articul' ]     = 2;
        $product_fields[ 'name' ]        = 3;

        return [
            [
                $filters,
                'VALUES' => [
                    'page'        => 1,
                    'limit'       => 2,
                    'category_id' => 3,
                ],
            ],
            [
                $product_fields,
                'VALUES' => [
                    'client_code' => 1,
                    'articul'     => 2,
                    'name'        => 3,
                ],
            ],
        ];
    }

    /**
     * @dataProvider emptyParams
     *
     * @param Params $params
     * @param array  $values
     *
     * @return Params
     */
    public function testOffsetSet( $params, $values )
    {
        foreach( $values as $key => $value ){
            $params[ $key ] = $value;
        }

        return $params;
    }

    /**
     * @dataProvider fullyParams
     *
     * @param Params $params
     * @param array  $values
     */
    public function testGet_array( $params, $values )
    {
        $this->AssertEquals($params->get_array(), $values);
    }

    /**
     * @dataProvider fullyParams
     *
     * @param Params $params
     * @param array  $values
     */
    public function testOffsetGet( $params, $values )
    {
        $params[ key($values) ] = 'test';
    }

    /**
     * @dataProvider fullyParams
     *
     * @param Params $params
     * @param array  $values
     */
    public function testOffsetExists( $params, $values )
    {
        $this->assertTrue($params->offsetExists(key($values)));

    }

    /**
     * @dataProvider             fullyParams
     *
     * @expectedException \Priceva\PricevaException
     * @expectedExceptionMessage You can use only valid parameter names.
     *
     * @param Params $params
     */
    public function testOffsetSetThrowException( $params )
    {
        $params[ 'wrong_param' ] = 1;
    }

    /**
     * @dataProvider fullyParams
     *
     * @param Params $params
     */
    public function testCount( $params )
    {
        $this->assertEquals(count($params), 3);
    }

    /**
     * @dataProvider fullyParams
     *
     * @param Params $params
     * @param array  $values
     */
    public function testOffsetUnset( $params, $values )
    {
        unset($params[ key($values) ]);
        $this->assertEquals(count($params), 2);
    }
}
