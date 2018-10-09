<?php
/**
 * Created by PhpStorm.
 * S.Belichenko, email: stanislav@priceva.com
 * Date: 08.10.2018
 * Time: 14:30
 */

namespace Priceva;


/**
 * Class Result
 *
 * @package Priceva
 */
class Result
{
    /**
     * @var array $errors
     * @var int   $countErrors
     */
    private $errors     = [];
    private $errors_cnt = 0;

    /**
     * @var int    $timestamp
     * @var string $date
     * @var float  $time_execution_sec
     */
    private $timestamp          = 0;
    private $date               = 0;
    private $time_execution_sec = 0;

    /**
     * @var \stdClass $curl_response
     * @var mixed     $result
     * @var bool      $error
     */
    private $curl_response;
    private $result;
    private $error;

    /**
     * Result constructor.
     *
     * @param $curl_response
     */
    public function __construct( $curl_response )
    {
        $this->curl_response = $curl_response;

        if( isset($curl_response->errors_cnt) && $curl_response->errors_cnt > 0 ){
            $this->error = true;

            $this->errors     = $curl_response->errors;
            $this->errors_cnt = $curl_response->errors_cnt;

            $this->set_info($curl_response);
        }else{
            $this->error = false;

            $this->result = $curl_response->result;

            $this->set_info($curl_response);
        }
    }

    /**
     * @param \stdClass $curl_response
     */
    private function set_info( $curl_response )
    {
        $this->timestamp          = $curl_response->timestamp;
        $this->date               = $curl_response->date;
        $this->time_execution_sec = $curl_response->time_execution_sec;
    }

    /**
     * @return bool
     */
    public function error()
    {
        return $this->error;
    }

    /**
     * @return array|bool
     */
    public function get_errors()
    {
        if( $this->error ){
            return $this->errors;
        }else{
            return false;
        }
    }

    /**
     * @return array
     */
    public function get_info()
    {
        return [
            'timestamp'          => $this->timestamp,
            'date'               => $this->date,
            'time_execution_sec' => $this->time_execution_sec,
        ];
    }

    /**
     * @return \stdClass
     * @throws PricevaException
     */
    public function get_raw()
    {
        if( $this->error ){
            throw new PricevaException(null, 400);
        }else{
            return $this->curl_response;
        }
    }

    /**
     * @return mixed
     * @throws PricevaException
     */
    public function get_result()
    {
        if( $this->error ){
            throw new PricevaException(null, 400);
        }else{
            return $this->result;
        }
    }

    /**
     * @return \stdClass
     * @throws PricevaException
     */
    public function get_std_class()
    {
        if( $this->error ){
            throw new PricevaException(null, 400);
        }else{
            $result          = json_decode($this->result, false);
            $json_last_error = json_last_error();

            if( $json_last_error ){
                throw new PricevaException(null, 500);
            }else{
                return $result;
            }
        }
    }

    /**
     * @return array
     * @throws PricevaException
     */
    public function get_assoc()
    {
        if( $this->error ){
            throw new PricevaException(null, 400);
        }else{
            $result          = json_decode($this->result, true);
            $json_last_error = json_last_error();

            if( $json_last_error ){
                throw new PricevaException('');
            }else{
                return $result;
            }
        }
    }
}
