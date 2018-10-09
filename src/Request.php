<?php
/**
 * Created by PhpStorm.
 * User: Stas
 * Date: 08.10.2018
 * Time: 14:30
 */

namespace Priceva;


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
        return sprintf(self::URL_API_V1, $this->params['api_version']) . $action;
    }

    /**
     * @return Result
     * @throws PricevaException
     */
    public function start( )
    {
        $ch = curl_init();

        $url = $this->get_url($this->params[ 'action' ]);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Apikey: " . $this->params[ 'api_key' ],
        ]);

        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        $json_last_error = json_last_error();

        if ($json_last_error) {
            throw new PricevaException('', 400);
        } else {
            return new Result($response);
        }
    }
}
