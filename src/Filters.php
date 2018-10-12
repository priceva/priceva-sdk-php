<?php
/**
 * Created by PhpStorm.
 * User: S.Belichenko, email: stanislav@priceva.com
 * Date: 10.10.2018
 * Time: 10:24
 */

namespace Priceva;


class Filters extends \ArrayObject implements \JsonSerializable
{
    private $container = [];

    private $valid_parameters = [
        'page',
        'limit',
        'category_id',
        'brand_id',
        'company_id',
        'region_id',
        'active',
        'name',
        'articul',
        'client_code',
    ];

    /**
     * @return array
     */
    public function get_array()
    {
        return $this->container;
    }

    /**
     * @param array|Filters $array
     *
     * @throws PricevaException
     */
    public function merge( $array )
    {
        if( is_array($array) ){
            $this->container = array_merge($this->container, $array);
        }elseif( gettype($array) === 'object' and get_class($array) === 'Priceva\Filters' ){
            $this->container = array_merge($this->container, $array->get_array());
        }else{
            throw new PricevaException('Filters must be an array or an object of type Filters.');
        }
    }

    /**
     * @param string $offset
     * @param mixed  $value
     *
     * @throws PricevaException
     */
    public function offsetSet( $offset, $value )
    {
        if( is_null($offset) ){
            throw new PricevaException('You cannot add a nameless filters parameter.');
        }else{
            if( in_array($offset, $this->valid_parameters) ){
                $this->container[ $offset ] = $value;
            }else{
                throw new PricevaException('You can use only valid parameter names.');
            }
        }
    }

    public function getIterator()
    {
        return new FiltersIterator($this->container);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->container);
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists( $offset )
    {
        return isset($this->container[ $offset ]);
    }

    /**
     * @param string $offset
     */
    public function offsetUnset( $offset )
    {
        unset($this->container[ $offset ]);
    }

    /**
     * @param string $offset
     *
     * @return string|null
     */
    public function offsetGet( $offset )
    {
        return isset($this->container[ $offset ]) ? $this->container[ $offset ] : null;
    }

    public function jsonSerialize()
    {
        return $this->container;
    }
}
