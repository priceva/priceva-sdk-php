<?php
/**
 * Created by PhpStorm.
 * User: Stas
 * Date: 01.10.2018
 * Time: 16:52
 */

namespace Priceva;


class PricevaAPI
{
    const URL_API_V1 = 'https://api.priceva.com/api/v%s/';

    const METHOD_MAIN_PING = 'main/ping';

    const REQUEST_METHOD_POST = 'POST';
    const REQUEST_METHOD_GET  = 'GET';

    /**
     * @var string $api_key
     * @var int    $api_version
     * @var string $request_method
     */
    private $api_key        = '';
    private $api_version    = '';
    private $request_method = '';

    /**
     * @var array $errors
     * @var int   $countErrors
     */
    private $errors      = [];
    private $countErrors = 0;

    /**
     * @var int    $timestamp
     * @var string $date
     * @var float  $time_execution_sec
     */
    private $timestamp          = 0;
    private $date               = 0;
    private $time_execution_sec = 0;

    public function __construct( $api_key, $api_version = 1, $request_method = self::REQUEST_METHOD_POST )
    {
        $this->api_key        = $api_key;
        $this->api_version    = $api_version;
        $this->request_method = $request_method;
    }

    public function main_ping()
    {
        $this->request(self::METHOD_MAIN_PING);
    }

    private function get_request_url( $method )
    {
        return sprintf(self::URL_API_V1, $this->api_version) . $method;
    }

    private function request( $method )
    {
        $ch = curl_init();

        $url = $this->get_request_url($method);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Apikey: " . $this->api_key,
        ]);

        $response = json_decode(curl_exec($ch));

        curl_close($ch);

        if( !empty($response->errors) ){
            $this->errors      = $response->errors;
            $this->countErrors = $response->errors_cnt;
        }

        return $response;
    }
}
