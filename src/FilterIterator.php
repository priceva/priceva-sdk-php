<?php
/**
 * Created by PhpStorm.
 * User: S.Belichenko, email: stanislav@priceva.com
 * Date: 11.10.2018
 * Time: 12:37
 */

namespace Priceva;


class FilterIterator implements \Iterator
{
    private $container;


    public function __construct( $container )
    {
        $this->container = $container;
    }

    public function rewind()
    {
        reset($this->container);
    }

    public function current()
    {
        $var = current($this->container);

        return $var;
    }

    public function valid()
    {
        $key = key($this->container);
        $var = ( $key !== null && $key !== false );

        return $var;
    }

    public function key()
    {
        $var = key($this->container);

        return $var;
    }

    public function next()
    {
        $var = next($this->container);

        return $var;
    }
}
