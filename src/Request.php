<?php
/**
 * Created by PhpStorm.
 * S.Belichenko, email: stanislav@priceva.com
 * Date: 08.10.2018
 * Time: 14:30
 */

namespace Priceva;


use Priceva\Params\Filters;
use Priceva\Params\ProductFields;
use Priceva\Params\Sources;

/**
 * Class Request
 *
 * @package Priceva
 */
class Request
{
    const URL_API_V1 = 'https://api.priceva.com/api/v%s/';

    const METHOD_POST = 'POST';
    const METHOD_GET  = 'GET';

    private $params = [];

    /**
     * Request constructor.
     *
     * @param $params
     */
    public function __construct( $params )
    {
        $this->params = $params;
    }

    /**
     * @param string $action
     *
     * @return string
     */
    private function get_url( $action )
    {
        return sprintf(self::URL_API_V1, $this->params[ 'api_version' ]) . $action;
    }

    /**
     * @param Filters       $filters
     * @param Sources       $sources
     * @param ProductFields $product_fields
     *
     * @return Result
     * @throws PricevaException
     */
    public function start( $filters = null, $sources = null, $product_fields = null )
    {
        $ch = curl_init();

        $url = $this->get_url($this->params[ 'action' ]);

        $params = [
            'params' => [
                'filters'        => $filters,
                'sources'        => $sources,
                'product_fields' => $product_fields,
            ],
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Apikey: " . $this->params[ 'api_key' ],
        ]);

        $response = curl_exec($ch);

        if( $response ){
            $response = json_decode($response);
            curl_close($ch);

            $json_last_error = json_last_error();

            if( $json_last_error ){
                throw new PricevaException('Server answer cannot be decoded. Error code: ' . $json_last_error, 500);
            }else{
                return new Result($response);
            }
        }else{
            $curl_error = curl_error($ch);
            curl_close($ch);
            throw new PricevaException('cURL error: ' . $curl_error, 500);
        }
    }
}
